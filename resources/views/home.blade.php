<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Mobile Shop Management System | {{ $company->name }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_style/assets/img/fav.png') }}"/>
    <link href="{{ asset('admin_style/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('admin_style/assets/js/loader.js') }}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('admin_style/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_style/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{ asset('admin_style/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_style/assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('admin_style/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_style/assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

</head>
<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <div class="nav-logo align-self-center">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="navbar-brand-name">
                        {{ $company->name }}
                    </span>
                </a>
            </div>

            <ul class="navbar-item flex-row mr-auto">
                <li class="nav-item align-self-center search-animated">

                </li>
            </ul>

            <ul class="navbar-item flex-row nav-dropdowns">

                <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">

                    {{-- <a href="{{ url('settings') }}" class="nav-link btn btn-info font-weight-bold text-uppercase" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cogs"></i> Settings
                    </a> --}}

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

                <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">

                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="nav-link btn btn-danger font-weight-bold text-uppercase" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-power-off"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
        <div class="topbar-nav header navbar" role="banner">
            <nav id="topbar">
                <ul class="navbar-nav theme-brand flex-row  text-center">

                    <li class="nav-item theme-text">
                        <a href="{{ route('home') }}" class="nav-link"> {{ $company->name }} </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="topAccordion">

                    <li class="menu single-menu ">
                        <a href=""  style="padding-right: 10px; padding-left: 10px; font-size: 16px; font-weight: bold;">
                            Welcome back <span class="ml-1 text-bold text-primary">{{ Auth::user()->name }}</span>
                        </a>

                    </li>


                </ul>
            </nav>
        </div>
        <!--  END TOPBAR  -->

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="page-header"></div>

                <div class="row layout-top-spacing">

                        <div class="col-lg-12" >
                            <div class="row">

                                <div id="card_3"
                                    @if (Auth::user()->hasRole('Admin'))
                                        class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                    @else
                                        class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                    @endif
                                    >

                                    @if (Auth::user()->hasRole('Admin'))
                                        <a href="{{ url('admin/inventory') }}">
                                    @else
                                        <a href="{{ url('admin/inventory') }}">
                                    @endif
                                        <div class="component-card_3 bg-primary">
                                            <div class="card-body">
                                                <img src="{{ asset('admin_style/assets/img/icons/3.svg') }}" class="card-img-top" alt="...">
                                                <h5 class="card-user_name text-uppercase">Inventory</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div id="card_3"
                                        @if (Auth::user()->hasRole('Admin'))
                                            class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                        @else
                                            class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                        @endif
                                        >

                                        @if (Auth::user()->hasRole('Admin'))
                                            <a href="{{ url('admin/invoices') }}">
                                        @else
                                            <a href="{{ url('admin/invoices') }}">
                                        @endif

                                        <div class="component-card_3 bg-success">
                                            <div class="card-body">
                                                <img src="{{ asset('admin_style/assets/img/icons/4.svg') }}" class="card-img-top" alt="...">
                                                <h5 class="card-user_name text-uppercase">Invoices</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                {{-- <div id="card_3"
                                        @if (Auth::user()->hasRole('Admin'))
                                            class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                        @else
                                            class="col-lg-6 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                        @endif
                                        >

                                        @if (Auth::user()->hasRole('Admin'))
                                            <a href="{{ url('admin/orders') }}">
                                        @else
                                            <a href="{{ url('staff/orders') }}">
                                        @endif

                                        <div class="component-card_3 bg-info">
                                            <div class="card-body">
                                                <img src="{{ asset('admin_style/assets/img/icons/2.svg') }}" class="card-img-top" alt="...">
                                                <h5 class="card-user_name text-uppercase">Orders</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div> --}}

                                <div id="card_3"
                                        @if (Auth::user()->hasRole('Admin'))
                                            class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                        @else
                                            class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing"
                                        @endif
                                        >

                                        @if (Auth::user()->hasRole('Admin'))
                                            <a href="{{ url('admin/repair_items') }}">
                                        @else
                                            <a href="{{ url('admin/repair_items') }}">
                                        @endif

                                        <div class="component-card_3 bg-danger">
                                            <div class="card-body">
                                                <img src="{{ asset('admin_style/assets/img/icons/7.png') }}" class="card-img-top" alt="...">
                                                <h5 class="card-user_name text-uppercase">Repair Items</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                @if (Auth::user()->hasRole('Admin'))
                                    <div id="card_3" class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing">
                                        <a href="{{ url('admin/staffs') }}">
                                            <div class="component-card_3 bg-warning">
                                                <div class="card-body">
                                                    <img src="{{ asset('admin_style/assets/img/icons/8.png') }}" class="card-img-top" alt="...">
                                                    <h5 class="card-user_name text-uppercase">Staffs</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div id="card_3" class="col-lg-4 col-md-6 col-sm-12 col-xs-12 layout-spacing">
                                        <a href="{{ url('admin/accounts') }}">
                                            <div class="component-card_3 bg-secondary">
                                                <div class="card-body">
                                                    <img src="{{ asset('admin_style/assets/img/icons/5.svg') }}" class="card-img-top" alt="...">
                                                    <h5 class="card-user_name text-uppercase">Accounts</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-wrapper">
                    <div class="footer-section f-section-1 text-center">
                        <p class="">Copyright © {{date('Y')}} <strong> {{ $company->name }}</strong>, All rights reserved. Solutions by
                            <a target="_blank" href="https://www.lkdevops.com/">lkDevops</a></p>
                    </div>

                    {{-- <div class="footer-section f-section-1 text-center">
                        <p class="">Copyright © 2021 <strong> {{ $company->name }}</strong>, All rights reserved. Software by
                            <a target="_blank" href="https://speeditviewer.com/">Speed IT Viewer</a></p>
                    </div> --}}

                </div>

            </div>
        </div>


        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('admin_style/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('admin_style/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin_style/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_style/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin_style/plugins/blockui/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('admin_style/assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset('admin_style/plugins/highlight/highlight.pack.js') }}"></script>
    <script src="{{ asset('admin_style/assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('admin_style/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin_style/assets/js/dashboard/dash_2.js') }}"></script>
    <script src="{{ asset('admin_style/assets/js/fontawesome.js') }}"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="{{ asset('admin_style/assets/js/scrollspyNav.js') }}"></script>
</body>
</html>
