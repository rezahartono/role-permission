<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\AccessList;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AccessListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $accessList = AccessList::select()->get();
            $datatable = new DataTable($accessList, '', '/settings/access-list/edit', '/settings/access-list/delete');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Access List",
        ];
        return view('pages.settings.access_list.index', $data);
    }

    public function store()
    {
        $data = [
            "user" => Auth::user(),
            "title" => "Create Menu",
        ];
        return view('pages.settings.access_list.create', $data);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'key' => 'required|unique:menu_lists,key|max:255',
                'description' => 'max:255',
                'menu' => 'max:100',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $access = new AccessList();
            $access->id = Uuid::uuid();
            $access->name = $request->name;
            $access->description = $request->description;
            $access->key = $request->key;
            $access->menu = $request->menu;
            $access->created_at = Carbon::now();
            $access->updated_at = Carbon::now();
            $access->save();

            if ($access != null) {
                Alert::success('Success', 'Access has been created');
                return redirect()->route('settings.access_list');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public function edit($id)
    {
        $data = [
            "user" => Auth::user(),
            "title" => "Edit Menu",
            "access" => AccessList::with('parentMenu')->where("id", $id)->first(),
        ];
        return view('pages.settings.access_list.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'key' => 'required|unique:menu_lists,key,' . $id,
                'description' => 'max:255',
                'menu' => 'max:100',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }


            $access = AccessList::where('id', $id)->first();
            $access->name = $request->name;
            $access->description = $request->description;
            $access->key = $request->key;
            $access->menu = $request->menu;
            $access->updated_at = Carbon::now();
            $access->update();

            if ($access) {
                Alert::success('Success', 'Access has been update');
                return redirect()->route('settings.access_list');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $accessList = AccessList::where('id', $id)->first();
            $accessList->delete();

            if ($accessList) {
                Alert::success('Success', 'Access has been deleted!');
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
