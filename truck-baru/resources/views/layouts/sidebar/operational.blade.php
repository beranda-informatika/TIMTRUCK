<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a href="{{ route('root') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="package"></i>
                        <span data-key="t-apps">@lang('translation.Sales Order')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li>
                            <a href="{{ route('shipment.index') }}">
                                Sales Order
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settlement.index') }}">
                                Settlement SO
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="package"></i>
                        <span data-key="t-apps">@lang('translation.UJO')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('ujo.create') }}">
                               Create UJO
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ujo.listujo') }}">
                               UJO
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="printer"></i>
                        <span data-key="t-apps">@lang('translation.Report')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('report.rptshipment') }}">
                                Report Shipment
                            </a>
                        </li>


                    </ul>
                </li>

                @if(Auth::user()->roles_id==4)

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">@lang('translation.Master')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                        <a href="{{ route('rute.index') }}">

                            <span> Route </span>
                        </a>
                        </li>
                        <li>
                            <a href="{{ route('project.index') }}">
                                <span data-key="t-calendar">Project</span>
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

                    </ul>
                </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-authentication">@lang('translation.Authentication')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(Session::get('roles_id')==1 || Session::get('roles_id')==5)
                        <li><a href="{{ route('utility.userpassword') }}" data-key="t-register">User List</a></li>
                        <li><a href="{{ route('utility.register') }}"
                                data-key="t-register">@lang('translation.Register')</a></li>
                        @endif
                        <li><a href="{{ route('utility.gantipassword') }}"
                                data-key="t-recover-password">@lang('translation.Recover_Password')</a></li>
                        <li><a href="{{ route('utility.userlog') }}" data-key="t-register">Login History</a></li>
                </li>
            </ul>
            </li>



            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
