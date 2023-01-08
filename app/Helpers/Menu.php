<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Menu
{
    public $current;

    public function __construct()
    {
        $this->current = Request::url();
    }

    /**
     *  Prepare Menu List
     *
     */
    public static function prepare()
    {
        $user = Auth::user();
        $role = User::with('group')->where('id', $user->id)->get();
        return $role;
    }
}
