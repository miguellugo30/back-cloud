<aside class="control-sidebar control-sidebar-{{ config('adminlte.right_sidebar_theme') }}" style="height: auto">
    @yield('right-sidebar')
    {{-- dd($adminlte->menu('navbar-right'))--}}
    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav flex-column" >
                @each('adminlte::partials.navbar.menu-item-link', $adminlte->menu("navbar-right"), 'item')
            </ul>
        </nav>
    </div>
</aside>
