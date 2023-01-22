<?php

namespace App\Http\Controllers\MasterData;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GroupsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $groups = Group::select()->get();
            $datatable = new DataTable($groups, '', '/master-data/groups/edit', '/master-data/groups/delete');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Groups",
        ];
        return view('pages.master-data.groups.index', $data);
    }

    public function store()
    {
        $data = [
            "user" => Auth::user(),
            "title" => "Create Group",
        ];
        return view('pages.master-data.groups.create', $data);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'max:255',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $group = new Group();
            $group->id = Uuid::uuid();
            $group->name = $request->name;
            $group->description = $request->description;
            $group->created_at = Carbon::now();
            $group->updated_at = Carbon::now();
            $group->save();

            if ($group != null) {
                Alert::success('Success', 'Group has been created');
                return redirect()->route('master_data.groups');
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
            "group" => Group::where("id", $id)->first(),
        ];
        return view('pages.master-data.groups.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'max:255',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $group = Group::where("id", $id)->first();
            $group->name = $request->name;
            $group->description = $request->description;
            $group->updated_at = Carbon::now();
            $group->update();

            if ($group) {
                Alert::success('Success', 'Group has been update');
                return redirect()->route('master_data.groups');
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $group = Group::where('id', $id)->first();
            $group->delete();

            if ($group) {
                Alert::success('Success', 'Group has been deleted!');
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
