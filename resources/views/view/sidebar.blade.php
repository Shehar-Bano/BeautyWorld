<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('dashboard') }}" aria-expanded="false"><i class="mdi me-2 mdi-gauge"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <!-- Orders Section -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="mdi me-2 mdi-cart"></i><span class="hide-menu">Orders</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <!-- Add Order to Cart -->
                        <li class="sidebar-item mt-2">
                            <a href="{{ route('cart.index') }}" class="sidebar-link">
                                <i class="mdi mdi-cart-plus"></i><span class="hide-menu"> Add to Cart </span>
                            </a>
                        </li>
                        <!-- View Order Details -->
                        <li class="sidebar-item">
                            <a href="" class="sidebar-link">
                                <i class="mdi mdi-cart-outline"></i><span class="hide-menu"> Order Details </span>
                            </a>
                        </li>
                    </ul>
                </li>
                @php
                    $user = Auth::user();
                @endphp
                @if ($user->hasRole('admin'))
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/permission') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Permission</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/role') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Role</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/role-permission') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Role to
                                Permission</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('user.role.index') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Role to User</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('employees.index') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Employees</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('inventories.index') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Inventories</span></a>
                    </li>
                @endif
                @if ($user->hasRole('admin') || $user->hasRole('manager'))
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('deals.index') }}" aria-expanded="false">
                            <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Deals</span></a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="mdi me-2 mdi-settings"></i><span class="hide-menu">Manage Expencess</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item mt-2">
                                <a href="{{ route('expence_categories.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu"> Category
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('expences.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-briefcase"></i><span class="hide-menu"> Expences </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!-- Manage Services Section -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="mdi me-2 mdi-settings"></i><span class="hide-menu">Manage Services</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item mt-2">
                            <a href="{{ route('service_categories.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu"> Category </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('services.index') }}" class="sidebar-link">
                                <i class="mdi mdi-briefcase"></i><span class="hide-menu"> Service </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{route('expence.report')}}" aria-expanded="false">
                        <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Expence Report</span></a>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{route('sales.report')}}" aria-expanded="false"><i class="mdi me-2 mdi-table"></i><span
                            class="hide-menu">Sales Report</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{route('balanceSheet')}}" aria-expanded="false"><i class="mdi me-2 mdi-emoticon"></i><span
                            class="hide-menu">BalanceSheet</span></a></li>
               

            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <div class="sidebar-footer">
        <div class="row">
            <div class="col-4 link-wrap">
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title=""
                    data-original-title="Settings"><i class="ti-settings"></i></a>
            </div>
            <div class="col-4 link-wrap">
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title=""
                    data-original-title="Email"><i class="mdi mdi-gmail"></i></a>
            </div>
            <div class="col-4 link-wrap">
                <!-- item-->
                <a class="link" data-toggle="tooltip" title="" data-original-title="Logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <i class="mdi mdi-power"> </i>
                        </x-dropdown-link>
                    </form>
                </a>
            </div>
        </div>
    </div>
</aside>
