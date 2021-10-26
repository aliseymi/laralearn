<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/img/IMG_20201019_234014_262.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">سیدعلی میرعربشاهی</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/admin" class="nav-link {{ isActive('admin.') }}">
                            <i class="fa fa-dashboard nav-icon"></i>
                            پنل مدیریت
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{ isActive(['admin.users.index','admin.users.create','admin.users.edit'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit']) }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                کاربران
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit']) }}">
                            <i class="nav-icon fa fa-id-card"></i>
                            <p>
                                بخش دسترسی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>دسترسی ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مقام ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
