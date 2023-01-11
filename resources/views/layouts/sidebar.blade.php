@php
    $menus = App\Helpers\Menu::getMenus();
    $activeMenus = App\Helpers\Menu::getActiveMenus();
    $isSuperAdmin = App\Helpers\Menu::isSuperAdmin();
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('vendor') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">MY APPS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @foreach ($menus as $menu)
                    @if (sizeof($menu->children) >= 1)
                        @if ($isSuperAdmin)
                            <li class="nav-item  @if (str_contains(Route::current()->getName(), $menu->key)) menu-is-opening menu-open @endif">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon {{ $menu->icon_class }}"></i>
                                    <p>
                                        {{ $menu->name }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach ($menu->children as $child)
                                        <li class="nav-item">
                                            <a href="{{ route($child->key) }}"
                                                class="nav-link @if (Route::current()->getName() == $child->key) active @endif">
                                                <i class="nav-icon {{ $child->icon_class }}"></i>
                                                <p>
                                                    {{ $child->name }}
                                                </p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @foreach ($activeMenus as $activeMenu)
                                <li
                                    class="nav-item  @if (str_contains(Route::current()->getName(), $menu->key)) menu-is-opening menu-open @endif @if ($menu->id != $activeMenu) d-none @endIf">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon {{ $menu->icon_class }}"></i>
                                        <p>
                                            {{ $menu->name }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($menu->children as $child)
                                            @foreach ($activeMenus as $activeMenu)
                                                <li class="nav-item @if ($child->id != $activeMenu) d-none @endIf">
                                                    <a href="{{ route($child->key) }}"
                                                        class="nav-link @if (Route::current()->getName() == $menu->key) active @endif">
                                                        <i class="nav-icon {{ $child->icon_class }}"></i>
                                                        <p>
                                                            {{ $child->name }}
                                                        </p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        @endif
                    @else
                        @if ($isSuperAdmin)
                            <li class="nav-item">
                                <a href="{{ route($menu->key) }}"
                                    class="nav-link @if (Route::current()->getName() == $menu->key) active @endif">
                                    <i class="nav-icon {{ $menu->icon_class }}"></i>
                                    <p>
                                        {{ $menu->name }}
                                    </p>
                                </a>
                            </li>
                        @else
                            @foreach ($activeMenus as $activeMenu)
                                <li class="nav-item @if ($menu->id != $activeMenu) d-none @endIf">
                                    <a href="{{ route($menu->key) }}"
                                        class="nav-link @if (Route::current()->getName() == $menu->key) active @endif">
                                        <i class="nav-icon {{ $menu->icon_class }}"></i>
                                        <p>
                                            {{ $menu->name }}
                                        </p>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endif
                @endforeach
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('roles') }}" class="nav-link">
                                <i class="fas fa-user-cog nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('menu_list') }}" class="nav-link">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>Menu List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('access_list') }}" class="nav-link">
                                <i class="fas fa-shield-alt nav-icon"></i>
                                <p>Access List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">
                                <i class="fas fa-user-alt nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Groups</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
