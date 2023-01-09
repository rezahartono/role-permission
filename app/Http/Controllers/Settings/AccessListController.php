<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\AccessList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AccessListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $accessList = AccessList::select()->get();
            $datatable = new DataTable($accessList, '', '', '/settings/roles/delete/');
            return $datatable->generate();
        }

        $data = [
            "user" => Auth::user(),
            "title" => "Access List",
        ];
        return view('pages.settings.access_list.index', $data);
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
