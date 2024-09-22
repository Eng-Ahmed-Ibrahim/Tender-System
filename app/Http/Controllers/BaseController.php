<?php

namespace App\Http\Controllers;

use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;

abstract class BaseController extends Controller
{
    protected $modelClass;
    protected $viewPrefix;
    protected $routePrefix;

    public function __construct()
    {
        if (!$this->modelClass || !$this->viewPrefix) {
            throw new \Exception('Model class and view prefix must be defined.');
        }
    }

    public function index(Request $request)
    {
        $models = $this->modelClass::paginate(10);
        return view($this->viewPrefix . '.index', compact('models'));
    }

    public function create()
    {
        return view($this->viewPrefix . '.create');
    }

    public function show($id)
    {
        $model = $this->modelClass::findOrFail($id);
        return view($this->viewPrefix . '.show', compact('model'));
    }
    public function edit($id)
    {
        $model = $this->modelClass::findOrFail($id);
        return view($this->viewPrefix . '.edit', compact('model'));
    }
    public function store(Request $request)
{
    $validatedData = $this->validateRequest($request);
    
    // Handle file uploads
    $validatedData = $this->handleFileUpload($request, $validatedData);

    $model = new $this->modelClass($validatedData);
    
    $model->save();

    $this->translateAndSave($request->all(), 'store');

    return redirect()->route($this->routePrefix . '.index')->with('success', 'Record created successfully.');
}


    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRequest($request);
        $model = $this->modelClass::findOrFail($id);

        if ($request->hasFile('photo')) {
            $fileName = $this->handleFileUpload($request->file('photo'));
            $model->photo = $fileName;
        }

        $model->update($validatedData);

        $this->translateAndSave($request->all(), 'update');

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Record updated successfully.');
    }

    public function destroy($id)
    {
        $model = $this->modelClass::findOrFail($id);
        $model->delete();

        return redirect()->route($this->routePrefix . '.index')->with('info', 'Record deleted successfully.');
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate($this->rules());
    }

    abstract protected function rules();

    protected function redirectToIndex($message)
    {
        return redirect()->route($this->routePrefix . '.index')->with('success', $message);
    }
    protected function handleFileUpload(Request $request, array $validatedData)
    {
        // Handle single file upload (e.g., photo)
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }
    
        // Handle multiple file uploads (e.g., images)
        if ($request->hasFile('images')) {
            $filePaths = [];
            foreach ($request->file('images') as $image) {
                $filePaths[] = $image->store('images', 'public');
            }
            $validatedData['images'] = json_encode($filePaths); // Store as JSON
        }
    
        return $validatedData;
    }
    

    protected function translateAndSave(array $inputs, $operation)
    {
        $languages = ['en', 'fr', 'es', 'ar'];
    
        foreach ($inputs as $key => $value) { 
            if (is_string($value) && !empty($value)) {
                // Dispatch the job for each input value
                dispatch(new TranslateText($key, $value, $languages));
            }
        }
    }
    

}
