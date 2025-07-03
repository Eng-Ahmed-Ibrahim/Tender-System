<?php

namespace App\Http\Controllers\Company;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Tender;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Exports\TendersExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Tender::query();

        if (auth()->user()->role == 'admin_company' || auth()->user()->role == 'company') {
            $query->where('company_id', auth()->user()->company_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('end_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        if (auth()->user()->role === 'admin' && $request->has('companies')) {
            $query->whereIn('company_id', $request->companies);
        }

        // Simple city filter
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }

        if ($request->filled('status')) {
            $now = Carbon::now();
            if ($request->status === 'open') {
                $query->where('end_date', '>', $now);
            } elseif ($request->status === 'closed') {
                $query->where('end_date', '<=', $now);
            }
        }

        switch ($request->get('sort', 'date-desc')) {
            case 'date-asc':
                $query->oldest();
                break;
            case 'title-asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title-desc':
                $query->orderBy('title', 'desc');
                break;
            case 'date-desc':
            default:
                $query->latest();
                break;
        }

        $tenders = $query->paginate(10)->withQueryString();

        $companies = auth()->user()->role === 'admin' ? \App\Models\Company::all() : null;

        // Get all unique cities for generating the dropdown

        // Sort cities alphabetically                
        $countries = Country::all();
        if ($request->ajax() && $request->has('partial')) {
            return view('company.tenders.partials.tender-grid', compact('tenders'))->render();
        }

        return view('company.tenders.index', compact('tenders', 'companies', 'countries'));
    }




    public function export(Request $request, $format)
    {
        $user = Auth::user();

        // Build the base query
        $query = Tender::query()
            ->when($user->role == 'admin_company', function ($query) use ($user) {
                return $query->where('company_id', $user->company_id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->search}%")
                        ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('startDate'), function ($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->startDate);
            })
            ->when($request->filled('endDate'), function ($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->endDate);
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('companies'), function ($query) use ($request) {
                return $query->whereIn('company_id', $request->companies);
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                switch ($request->sort) {
                    case 'date-desc':
                        return $query->latest();
                    case 'date-asc':
                        return $query->oldest();
                    case 'title-asc':
                        return $query->orderBy('title', 'asc');
                    case 'title-desc':
                        return $query->orderBy('title', 'desc');
                    default:
                        return $query->latest();
                }
            });

        // Get the filtered tenders
        $tenders = $query->with(['company'])->get();

        // Generate filename
        $filename = 'tenders_export_' . now()->format('Y-m-d');

        // Handle export based on format
        if ($format === 'excel') {
            return Excel::download(
                new TendersExport($tenders),
                $filename . '.xlsx'
            );
        } else {
            $pdf = app('dompdf.wrapper');
            return $pdf->loadView('pdf.tenders', [
                'tenders' => $tenders,
                'filters' => [
                    'dateRange' => $request->filled('startDate') ?
                        "{$request->startDate} to {$request->endDate}" : 'All Time',
                    'status' => $request->status ?? 'All',
                    'companies' => $request->companies ?? 'All Companies',
                ],
                'user' => $user
            ])->download($filename . '.pdf');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = \App\Models\Company::all();
        $countries = Country::all();
        return view('company.tenders.create', compact('companies', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'title_ar' => 'string|max:255',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'first_insurance' => 'nullable',
            'price' => 'required',
            'description' => 'required|string',
            'description_ar' => 'string',
            'end_date' => 'required|date|after:now', // Added after:now validation
            'edit_end_date' => 'required|date|after:now', // Added after:now validation
            'show_applicants' => 'boolean',
        ]);

         $end_date = Carbon::parse($validatedData['end_date']);
        $edit_date = Carbon::parse($validatedData['edit_end_date']);
        if ($end_date->lt($edit_date)) {
            return response()->json([
                'success' => false,
                'errors' => ["end_date"=>['End date must be greater than Deadline date.']]
            ], 422);
        }


        // Additional check for dates in case the validation rule is bypassed
        if (
            \Carbon\Carbon::parse($validatedData['end_date'])->isPast() ||
            \Carbon\Carbon::parse($validatedData['edit_end_date'])->isPast()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Both end date and edit end date must be in the future.'
            ], 422);
        }

        $qrCode = QrCode::generate(url('/tenders/' . $validatedData['company_id']));
        $qrCodePath = 'qrcodes/tender_' . time() . '.svg'; //
        Storage::disk('public')->put($qrCodePath, $qrCode);

        $tender = Tender::create(array_merge($validatedData, ['qr_code' => $qrCodePath]));

        return response()->json([
            'success' => true,
            'message' => __('Tender created successfully.'),
            'tender' => $tender
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tender = Tender::where("id", $id)->with(['applicants'])->first();
        $end_date = Carbon::parse($tender->end_date);

        if ($end_date->lt(Carbon::now())) {
            $editEndDate = Carbon::parse($tender->edit_end_date);
            $tender->update([
                'status' => 0,
                'end_date' => now(),
                'edit_end_date' => $editEndDate->gt(Carbon::today()) ? now() : $editEndDate,

            ]);
        }

        // return $tender;

        $qrCode = QrCode::size(200)
            ->backgroundColor(255, 255, 255) // Set background to white
            ->color(0, 0, 0) // Set QR code color to black
            ->margin(1)
            ->generate(url("/api/ApiAllTenders/{$tender->id}"));

        return view('company.tenders.show', compact('tender', 'qrCode'));
    }


    public function generateQrCode($id)
    {
        $tender = Tender::findOrFail($id);


        return QrCode::size(400)
            ->backgroundColor(128, 128, 128)
            ->margin(1)
            ->generate(url("/api/ApiAllTenders/{$tender->id}"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tender = Tender::findOrFail($id);
        $companies = \App\Models\Company::all();
        $countries = Country::all();
        $cities = City::where("country_id", $tender->country_id)->get();
        return view('company.tenders.edit', compact('tender', 'companies', 'countries', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'first_insurance' => 'numeric',
            'price' => 'numeric',
            'description' => 'required|string',
            'description_ar' => 'required|string',
            'end_date' => 'required|date',
            'edit_end_date' => 'required|date',
            "city_id" => "required",
            "country_id" => "required",
            'show_applicants' => 'boolean',
        ]);
        
        $tender = Tender::where("id", $id)->with(['applicants'])->first();
        
        $end_date = Carbon::parse($validatedData['end_date']);
        $edit_date = Carbon::parse($validatedData['edit_end_date']);
        if ($end_date->lt($edit_date)) {
            return response()->json([
                'success' => false,
                'errors' => ["end_date"=>['End date must be greater than Deadline date.']]
            ], 422);
        }


        // Find the tender by ID
        $tender = Tender::findOrFail($id);

        // Update the QR code if the company_id or relevant details change
        if ($tender->company_id !== $validatedData['company_id'] || $tender->title !== $validatedData['title']) {
            $qrCode = QrCode::generate(url('/tenders/' . $validatedData['company_id']));
            $qrCodePath = 'qrcodes/tender_' . time() . '.svg';
            Storage::disk('public')->put($qrCodePath, $qrCode);

            $validatedData['qr_code'] = $qrCodePath;
        }

        // Update the tender record
        $tender->update($validatedData);

        // Return a response indicating success
        return response()->json(['success' => true, 'message' =>  __('Tender updated successfully.'), 'tender' => $tender]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download($id)
    {
        $tender = Tender::findOrFail($id);

        $qrCode = QrCode::size(200)
            ->format('png')
            ->generate(route('tenders.show', $tender->id));

        return response()->stream(
            function () use ($qrCode) {
                echo $qrCode;
            },
            200,
            [
                'Content-Type' => 'image/png',
            ]
        );
    }


    public function stopTender($id)
    {

        $tender = Tender::findOrFail($id);

        if ($tender->end_date <= now()) {
            return redirect()->back()->with('error', __('Tender is already ended or stopped'));
        }

        DB::beginTransaction();
        $editEndDate = Carbon::parse($tender->edit_end_date);

        $tender->update([
            'status' => 0,
            'end_date' => now(),
            'edit_end_date' => $editEndDate->gt(Carbon::today()) ? now() : $editEndDate,

        ]);

        DB::commit();

        return redirect()->back()->with('success', __('Tender has been stopped successfully'));
    }
}
