<?php

namespace App\Http\Controllers\MasterData;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select()->get();
            $datatable = new DataTable($users, '', '', '/master-data/users/delete/');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Users",
        ];
        return view('pages.master-data.users.index', $data);
    }

    public function store()
    {
        $data = [
            "user" => Auth::user(),
            "title" => "Create Users",
            "users" => $this->users,
            "roles" => Role::get(),
        ];
        return view('pages.master-data.users.create', $data);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'role' => 'required',
                'status' => 'required',
                'password' => 'required|min:8|max:50',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $user = new User();
            $user->id = Uuid::uuid();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = $request->status;
            $user->password = $request->password;
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();
            $user->save();

            if ($user != null) {
                Alert::success('Success', 'User has been created');
                return redirect()->route('users');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->delete();

            if ($user) {
                Alert::success('Success', 'User has been deleted!');
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
