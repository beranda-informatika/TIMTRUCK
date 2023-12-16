<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">

            <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="user-img" title="Mat Helme"
                class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"
                    aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>

            <p class="text-muted left-user-info">{{ Auth::user()->email }}</p>


        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="/">
                        <i class="mdi mdi-view-dashboard-outline"></i>

                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Apps</li>
                <li>
                    <a href="#marketing" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-multiple-outline"></i>
                        <span> Marketing </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="marketing">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('quotation.index') }}">
                                    Shipment Planning
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#operasional" data-bs-toggle="collapse">
                        <i class="mdi mdi-text-box-outline"></i>
                        <span> Operasional </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="operasional">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('shipment.create') }}">
                                    Registrasi Shipment
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shipment.index') }}">
                                List Shipment Quotation
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('approve.search') }}">
                                    Shipment Approval
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shiping.search') }}">
                                    Shipment Shiping
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('arrival.search') }}">
                                    Shipment Arrival
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('approve.index') }}">
                                    List Shipment
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#finance" data-bs-toggle="collapse">
                        <i class="mdi mdi mdi-cash"></i>
                        <span> Finance </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="finance">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('payout.search') }}">
                                    Shipment Payout
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('payout.index') }}">
                                   Shipment List Payout
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bill.search') }}">
                                    Shipment Bill
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bill.index') }}">
                                   Shipment List Bill
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('payment.search') }}">
                                   Shipment Payment
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('rute.index') }}">
                        <i class="mdi mdi-map-marker-path"></i>
                        <span> Route </span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarExpages" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-multiple-outline"></i>
                        <span> Master </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarExpages">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('project.index') }}">
                                    Project
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('typetruck.index') }}">Type Truck</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.index') }}">
                                    Customer
                                </a>
                            </li>
                            <li>

                                <a href="{{ route('sales.index') }}">
                                    Sales
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('driver.index') }}">
                                    Driver
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('unit.index') }}">
                                    Unit
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('rate.index') }}">
                                    Rates
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#report" data-bs-toggle="collapse">
                        <i class="mdi mdi-text-box-outline"></i>
                        <span> Report </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="report">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('report.rptshipment') }}">
                                    Report Shipment
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.rptincome') }}">
                                    Report Income
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.rptbill') }}">
                                    Report Bill
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">Utils</li>

                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-multiple-plus-outline"></i>
                        <span> Auth Pages </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('utility.gantipassword')}}">Ubah Password</a>
                            </li>
                            <li>
                                <a href="{{ route('utility.userpassword')}}">User</a>
                            </li>

                            <li>
                                <a href="{{ route('utility.register')}}">Register</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
