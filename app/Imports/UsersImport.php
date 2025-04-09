<?php
namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $authUser = Auth::user();
        $company_id = $authUser->role == 'admin_company' ? $authUser->company_id : null;
        $rolee = $authUser->role == 'admin_company' ? 'admin_company' : 'admin';

        foreach ($rows as $row) {
            try {
                DB::beginTransaction();

                $user = new User();
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = Hash::make($row['password']);
                $user->phone = $row['phone'];
                $user->address = $row['address'];
                $user->company_id = $company_id;
                $user->role = $rolee;
                $user->save();

                if (!empty($row['role_id']) && Role::find($row['role_id'])) {
                    $user->assignRole($row['role_id']);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to import user', ['error' => $e->getMessage(), 'row' => $row]);
            }
        }
    }
}
