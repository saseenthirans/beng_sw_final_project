<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Mobile Shop Management System | {{$company->name}}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin_staff/assets/img/favicon.ico')}}"/>
    <link href="{{asset('admin_staff/assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('admin_staff/assets/js/loader.js')}}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{asset('admin_staff/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin_staff/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{asset('admin_staff/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin_staff/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_staff/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css"  href="{{ asset('admin_staff/plugins/table/datatable/dt-global_style.css') }}">

    <link href="{{asset('admin_staff/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin_staff/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('admin_staff/plugins/dropify/dropify.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_staff/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_staff/assets/css/forms/switches.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <link href="{{ asset('admin_staff/assets/css/apps/invoice-edit.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_staff/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_staff/plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_staff/plugins/dropify/dropify.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_staff/plugins/select2/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{ asset('admin_staff/assets/css/elements/infobox.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .btn-150 {
            background-color: #7382F5;
            color: #fff;
            width: 150px;
            height: 40px;
        }

        .btn-150:hover,
        .btn-150:focus {
            color: #fff !important;
            background-color: #7382F5;
            box-shadow: none;
            border-color: #7382F5;
        }

        .btn-150-danger {
            background-color: #e7515a;
            color: #fff;
            width: 150px;
            height: 40px;
        }

        .btn-150-danger:hover,
        .btn-150-danger:focus {
            color: #fff !important;
            background-color: #e7515a;
            box-shadow: none;
            border-color: #e7515a;
        }
    </style>
</head>
<body class="sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    {{-- <a href="javascript:void(0);">
                        <img src="{{asset('admin_staff/assets/img/logo.svg')}}" class="navbar-logo" alt="logo">
                    </a> --}}
                </li>
                <li class="nav-item theme-text">
                    {{-- <a href="javascript:void(0);" class="nav-link"> CORK </a> --}}
                </li>
                <li class="nav-item toggle-sidebar">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg></a>
                </li>
            </ul>



            <ul class="navbar-item flex-row search-ul">

            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Log out" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
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

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">
                <div class="profile-info">
                    <figure class="user-cover-image"></figure>
                    <div class="user-info">
                        <img src="{{asset(Auth::user()->image)}}" alt="avatar">
                        <h6 class="">{{ Auth::user()->name }}</h6>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">

                    @yield('menus')

                </ul>

            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

                    @yield('content')

                </div>

            </div>
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © {{date('Y')}} <a target="_blank" href="http://lkdevops.com/">LKDevops</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
        </div>
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('admin_staff/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('admin_staff/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('admin_staff/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_staff/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('admin_staff/assets/js/app.js')}}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{asset('admin_staff/assets/js/custom.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL admin_staff/plugins/CUSTOM SCRIPTS -->
    <script src="{{asset('admin_staff/plugins/apex/apexcharts.min.js')}}"></script>
    <script src="{{asset('admin_staff/assets/js/dashboard/dash_1.js')}}"></script>
    <!-- BEGIN PAGE LEVEL admin_staff/plugins/CUSTOM SCRIPTS -->

    <script src="{{ asset('admin_staff/plugins/table/datatable/datatables.js') }}"></script>

    <script src="{{asset('admin_staff/assets/js/scrollspyNav.js')}}"></script>
    <script src="{{asset('admin_staff/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script src="https://kit.fontawesome.com/7da253b858.js"></script>

    <script src="{{ asset('admin_staff/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('admin_staff/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('admin_staff/plugins/flatpickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('admin_staff/assets/js/apps/invoice-edit.js') }}"></script>
    <script src="{{ asset('admin_staff/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('admin_staff/plugins/select2/custom-select2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".disabled-results").select2();

            $('.summernote').summernote({
                placeholder: 'Full Description',
                tabsize: 2,
                height: 250
            });
        });
    </script>

    @yield('scripts')

</body>
</html>
