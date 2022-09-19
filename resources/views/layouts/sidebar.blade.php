@section('side')
<style>
    .sidebar li {
        padding: 10px 0px;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="https://images.ctfassets.net/l566d3egsswy/1W0U8jiVqernKMEmp6fyrm/ea6b58d0a6bf53942007e62309ebd1c4/favicon.webp"
                width="40">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Bytrix</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= request()->segment(2) == '' ? 'active' : ''; ?>">
            <a href="{{ url('admin') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Core</span>
        </li>
        <li class="menu-item <?= request()->segment(2) == 'brands' ? 'active open' : ''; ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Account Settings">Brands Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= request()->segment(2) == 'brands'
                                            && request()->segment(3) == 'index' ? 'active' : '';
                                        ?>">
                    <a href="{{ url('admin/brands/index') }}" class="menu-link">
                        <div data-i18n="Account">All Brands</div>
                    </a>
                </li>
                <li class="menu-item <?= request()->segment(2) == 'brands'
                                            && request()->segment(3) == 'create' ? 'active' : '';
                                        ?>">
                    <a href="{{ url('admin/brands/create') }}" class="menu-link">
                        <div data-i18n="Notifications">Create New Brand</div>
                    </a>
                </li>

            </ul>
        </li>
        <li class="menu-item <?= request()->segment(2) == 'services' ? 'active open' : ''; ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Authentications">Services</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= request()->segment(2) == 'services'
                                            && request()->segment(3) == 'index' ? 'active' : '';
                                        ?>">
                    <a href="{{ url('admin/services/index') }}" class="menu-link">
                        <div data-i18n="Basic">All Services</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- <li class="menu-item <?= request()->segment(2) == 'departments' ? 'active' : ''; ?>">
            <a href="{{ url('admin/departments') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Departments</div>
            </a>
        </li> -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Payments</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('') }}" class="menu-link">
                        <div data-i18n="Error">All Payments</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('admin/payment/create') }}" class="menu-link">
                        <div data-i18n="Under Maintenance">Create New</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item <?= request()->segment(2) == 'users' ? 'active open' : ''; ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">User Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= request()->segment(2) == 'users'
                                            && request()->segment(3) == '' ? 'active' : '';
                                        ?>">
                    <a href="{{ url('admin/users') }}" class="menu-link">
                        <div data-i18n="Error">All Employees</div>
                    </a>
                </li>
                <li class="menu-item <?= request()->segment(2) == 'users'
                                            && request()->segment(3) == 'index2' ? 'active' : '';
                                        ?>">
                    <a href="{{ url('admin/users/index2') }}" class="menu-link">
                        <div data-i18n="Error">All Clients</div>
                    </a>
                </li>
                <li class="menu-item <?= request()->segment(2) == 'users'
                                            && request()->segment(3) == 'create' ? 'active' : '';
                                        ?>">
                    <a href="{{ url('admin/users/create') }}" class="menu-link">
                        <div data-i18n="Under Maintenance">Create New</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Site Settings</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Authentications">Configuration Keys</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Email Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('admin/email_methods') }}" class="menu-link">
                        <div data-i18n="Error">Email Templates</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('admin/smtp_settings/smtp_config') }}" class="menu-link">
                        <div data-i18n="Error">SMTP Configuration</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Payment Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('admin/payment_methods') }}" class="menu-link">
                        <div data-i18n="Error">Payment Methods</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
@endsection