@can('show-discounts')
    <li class="nav-item">
        <a href="{{ route('admin.discount.index') }}" class="nav-link {{ isActive(['admin.discount.index','admin.discount.create','admin.discount.edit']) }}">
            <i class="fa fa-ticket nav-icon"></i>
            مدیریت تخفیف ها
        </a>
    </li>
@endcan
