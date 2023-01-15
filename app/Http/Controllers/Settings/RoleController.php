<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\MenuList;
use App\Models\Role;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select()->get();
            $datatable = new DataTable($roles, '', '/settings/roles/edit', '/settings/roles/delete');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Roles",
        ];
        return view('pages.settings.roles.index', $data);
    }

    public function store()
    {
        $rawMenus = MenuList::with('children')->whereNull('parent')->orderBy('order', 'ASC')->get();
        $menus = array();
        foreach ($rawMenus as $menu) {
            if (sizeof($menu->children) == 0) {
                array_push($menus, ["id" => $menu->id, "text" => $menu->name]);
            } else {
                $children = array();
                foreach ($menu->children as $chl) {
                    array_push($children, ["id" => $chl->id, "text" => $chl->name]);
                }
                array_push($menus, ["id" => $menu->id, "text" => $menu->name, "children" => $children,]);
            }
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Create Role",
            "menus" => $menus,
        ];
        return view('pages.settings.roles.create', $data);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'max:255',
                'access_type' => 'required|max:100',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $role = new Role();
            $role->id = Uuid::uuid();
            $role->name = $request->name;
            $role->description = $request->description;
            $role->access_type = $request->access_type;
            $role->access = json_encode($request->access);
            $role->created_at = Carbon::now();
            $role->updated_at = Carbon::now();
            $role->save();

            if ($role != null) {
                Alert::success('Success', 'Role has been created');
                return redirect()->route('roles');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public function edit($id)
    {
        $rawMenus = MenuList::with('children')->whereNull('parent')->orderBy('order', 'ASC')->get();
        $menus = array();
        foreach ($rawMenus as $menu) {
            if (sizeof($menu->children) == 0) {
                array_push($menus, ["id" => $menu->id, "text" => $menu->name]);
            } else {
                $children = array();
                foreach ($menu->children as $chl) {
                    array_push($children, ["id" => $chl->id, "text" => $chl->name]);
                }
                array_push($menus, ["id" => $menu->id, "text" => $menu->name, "children" => $children,]);
            }
        }

        $role = Role::where('id', $id)->first();
        $activeMenus = json_decode($role->access);
        $newActiveMenus = array();

        foreach ($activeMenus as $activeMenu) {
            $newMenu = MenuList::with('children')->where('id', $activeMenu)->first();
            if (sizeof($newMenu->children) == 0) {
                array_push($newActiveMenus, $activeMenu);
            }
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Create Role",
            "menus" => $menus,
            "role" => $role,
            "active_menus" => json_encode($newActiveMenus),
        ];

        return view('pages.settings.roles.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'max:255',
                'access_type' => 'required|max:100',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $role = Role::where('id', $id)->first();
            $role->name = $request->name;
            $role->description = $request->description;
            $role->access_type = $request->access_type;
            $role->access = json_encode($request->access);
            $role->updated_at = Carbon::now();
            $role->update();

            if ($role) {
                Alert::success('Success', 'Role has been updated');
                return redirect()->route('settings.roles');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
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
