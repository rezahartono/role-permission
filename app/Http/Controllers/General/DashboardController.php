<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [
            "user" => Auth::user(),
            "title" => "Dashboard",
        ];
        return view('pages.general.dashboard.index', $data);
    }
}
