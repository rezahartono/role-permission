<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\MenuList;
use Illuminate\Http\Request;

class LookupDatatableRenderer extends Controller
{
    public function menuList(Request $request)
    {
        if ($request->ajax()) {
            $menuList = MenuList::select()->get();
            $datatable = new DataTable($menuList);
            return $datatable->generateLookup();
        }
    }
}
