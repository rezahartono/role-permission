<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select()->get();
            $datatable = new DataTable($roles, '', '', '/settings/roles/delete/');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Roles",
        ];
        return view('pages.settings.roles.index', $data);
    }

    public function delete($id)
    {
        try {
            $role = Role::where('id', $id)->first();
            $role->delete();

            if ($role) {
                Alert::success('Success', 'Role has been deleted!');
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
