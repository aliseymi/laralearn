@can('show-modules-management')
    <li class="nav-item">
        <a href="{{ route('admin.modules.index') }}" class="nav-link {{ isActive('admin.modules.index') }}">
            <i class="fa fa-dashboard nav-icon"></i>
            مدیریت ماژول ها
        </a>
    </li>
@endcan
