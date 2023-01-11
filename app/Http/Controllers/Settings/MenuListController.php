<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\DataTable;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\MenuList;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MenuListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menuList = MenuList::select()->get();
            $datatable = new DataTable($menuList, '', '', '/settings/roles/delete/');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Menu List",
        ];
        return view('pages.settings.menu_list.index', $data);
    }

    public function store()
    {
        $data = [
            "user" => Auth::user(),
            "title" => "Create Menu",
        ];
        return view('pages.settings.menu_list.create', $data);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'key' => 'required|unique:menu_lists,key|max:255',
                'description' => 'max:255',
                'parent' => 'max:100',
                'icon' => 'required|max:255',
                'order' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $menu = new MenuList();
            $menu->id = Uuid::uuid();
            $menu->name = $request->name;
            $menu->description = $request->description;
            $menu->key = $request->key;
            $menu->parent = $request->parent;
            $menu->icon_class = $request->icon;
            $menu->order = $request->order;
            $menu->created_at = Carbon::now();
            $menu->updated_at = Carbon::now();
            $menu->save();

            if ($menu != null) {
                Alert::success('Success', 'Menu has been created');
                return redirect()->route('settings.menu_list');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $menu = MenuList::where('id', $id)->first();
            $menu->delete();

            if ($menu) {
                Alert::success('Success', 'Menu has been deleted!');
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
