<?php

namespace App\Helpers;

use App\Models\MenuList;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Menu
{
    public function __construct()
    {
    }

    /**
     *  Prepare Menu List
     *
     */
    public static function getActiveMenus()
    {
        $user = Auth::user();
        $role = Role::where('id', $user->role)->first();

        return json_decode($role->access);
    }

    public static function getMenus()
    {
        $menus = MenuList::with('children')->whereNull('parent')->orderBy('order', 'ASC')->get();
        return $menus;
    }

    public static function isSuperAdmin()
    {
        $user = Auth::user();
        $role = Role::where('id', $user->role)->first();

        return $role->access_type == "all";
    }
}
