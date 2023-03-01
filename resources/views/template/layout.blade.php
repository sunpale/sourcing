<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="dark" data-sidebar="dark" data-layout-style="detached" data-layout-position="fixed" data-sidebar-size="lg" data-preloader="enable">
<head>
    <meta charset="utf-8">
    <title>{{$title}} | Biensi Fesyenindo RM Manajemen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Biensi Fesyenindo RM Manajemen" name="description"/>
    <meta content="Biensi" name="author"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{!! asset('src/images/favicon.ico') !!}">

    <!-- Layout config Js -->
    <script src="{!! asset('src/js/layout.js') !!}"></script>
    <!-- Bootstrap Css -->
    <link href="{!! asset('src/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{!! asset('src/css/icons.min.css') !!}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{!! asset('src/css/app.min.css') !!}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{!! asset('src/css/custom.min.css') !!}" rel="stylesheet" type="text/css"/>

    <!-- Component Css-->
    @if($datatable)
    <link rel="stylesheet" type="text/css" href="{!! asset('src/libs/datatables/css/datatables.min.css') !!}">
    @endif
    @if($sweetalert)
    <link rel="stylesheet" type="text/css" href="{!! asset('src/libs/sweetalert2/sweetalert2.min.css') !!}">
    @endif
    @if($freezeUi)
    <link rel="stylesheet" type="text/css" href="{!! asset('src/libs/freeze-ui/freeze-ui.min.css') !!}">
    @endif
    @if($select2)
    <link rel="stylesheet" type="text/css" href="{!! asset('src/libs/select2/select2.min.css') !!}">
    @endif
    @if($dropzone)
    <link rel="stylesheet" type="text/css" href="{!! asset('src/libs/dropzone/dropzone.css') !!}">
    @endif
    @if($glightbox)
    <link rel="stylesheet" type="text/css" href="{!! asset('src/libs/glightbox/css/glightbox.min.css') !!}">
    @endif
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="/" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{!! asset('src/images/logo/logo-3second.png') !!}" alt="" class="logo-height-sm">
                            </span>
                            <span class="logo-lg">
                                <img src="{!! asset('src/images/logo/logo-white.png') !!}" alt="" class="logo-height-lg">
                            </span>
                        </a>
                        <a href="/" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{!! asset('src/images/logo/logo-3second.png') !!}" alt="" class="logo-height-sm">
                            </span>
                            <span class="logo-lg">
                                <img src="{!! asset('src/images/logo/logo-white.png') !!}" alt="" class="logo-height-lg">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                               aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{!! asset('src/images/user-img.jpg') !!}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name??'Guest'}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{session()->get('role')??'Guest'}}</span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome {{Auth::user()->name??'Guest'}}</h6>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="pages-profile-settings.html"><span
                                    class="badge bg-soft-success text-success mt-1 float-end">New</span><i
                                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Settings</span></a>
                            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Lock screen</span></a>
                            <a class="dropdown-item" href="#" id="btnlogout"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="/" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{!! asset('src/images/logo/logo-3second.png') !!}" alt="" class="logo-height-sm">
                </span>
                <span class="logo-lg">
                    <img src="{!! asset('src/images/logo/logo-3second.png') !!}" alt="" class="logo-height-lg">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{!! asset('src/images/logo/logo-3second.png') !!}" alt="" class="logo-height-sm">
                </span>
                <span class="logo-lg">
                    <img src="{!! asset('src/images/logo/logo-white.png') !!}" alt="" class="logo-height-lg">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#">
                            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                        </a>
                    </li> <!-- end Dashboard Menu -->
                    <li class="menu-title"><span data-key="t-master">Master Data</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarMasterMaterial" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMasterMaterial">
                            <i class="ri-apps-2-line"></i> <span data-key="t-apps">Master Raw Material</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarMasterMaterial">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{!! route('fabric.index') !!}" class="nav-link" data-key="t-fabric"> Jenis Fabric </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('komposisi.index') !!}" class="nav-link" data-key="t-komposisi"> Komposisi </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('raw-material.index') !!}" class="nav-link" data-key="t-aspek"> Raw Material </a>
                                </li>
                            </ul>
                        </div>
                    </li><!-- end Dashboard Menu -->

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarMasterAksesoris" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarMasterAksesoris">
                            <i class="ri-pantone-fill"></i> <span
                                data-key="t-authentication">Master Aksesoris</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarMasterAksesoris">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{!! route('product-group.index') !!}" class="nav-link" data-key="t-toko"> Product Group </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('aksesoris.index') !!}" class="nav-link" data-key="t-region"> Aksesoris </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarMasterWarna" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarMasterWarna">
                            <i class="ri-palette-line"></i> <span
                                data-key="t-authentication">Master Warna</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarMasterWarna">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{!! route('warna.index') !!}" class="nav-link" data-key="t-warna"> Warna MD </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('pantone.index') !!}" class="nav-link" data-key="t-region"> Pantone </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('warna-aksesoris.index') !!}" class="nav-link" data-key="t-region"> Warna Aksesoris </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{!! route('brands.index') !!}" aria-expanded="false">
                            <i class="icon-3second"></i> <span data-key="t-widgets">Brands</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{!! route('supplier.index') !!}" aria-expanded="false">
                            <i class="mdi mdi-truck-delivery"></i> <span data-key="t-widgets">Supplier</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('measure.index')}}" aria-expanded="false">
                            <i class="mdi mdi-tape-measure"></i> <span data-key="t-widgets">Unit of Measure</span>
                        </a>
                    </li>
                    {{-- <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Compliance</span>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link menu-link" href="#sidebarAudit" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAudit">
                             <i class="ri-pencil-ruler-2-line"></i> <span data-key="t-base-ui">Audit</span>
                         </a>
                         <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarAudit">
                             <div class="row">
                                 <div class="col-lg-4">
                                     <ul class="nav nav-sm flex-column">
                                         <li class="nav-item">
                                             <a href="--}}{{--{{route('audit.index')}}--}}{{--" class="nav-link" data-key="t-alerts">Data</a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="--}}{{--{{route('audit.start')}}--}}{{--" class="nav-link" data-key="t-badges">Input</a>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </li>--}}
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
    <!-- ========== End App Menu ========== -->

    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- Start main Content here -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {{--Start Page Title--}}
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            {!! \Diglactic\Breadcrumbs\Breadcrumbs::render($breadcrumbs) !!}
                        </div>
                        {{--End Page Title--}}
                    </div>
                </div>
                {{$slot}}
            </div>
            <!-- container-fluid -->
        </div>
    </div>
    <!-- End main Content here -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    {{date('Y')??''}} &copy; Digital Compliance by <a href="#" title="Muhammad Ihsan Nur Hikam">IT Development Biensi</a>.
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- End Begin Page -->
<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->
<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="{!! asset('src/libs/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<script src="{!! asset('src/libs/simplebar/simplebar.min.js') !!}"></script>
<script src="{!! asset('src/libs/node-waves/waves.min.js') !!}"></script>
<script src="{!! asset('src/libs/feather-icons/feather.min.js') !!}"></script>
<script src="{!! asset('src/js/plugins/lord-icon-2.1.0.js') !!}"></script>
<script src="{!! asset('src/js/app.js') !!}"></script>
<script src="{!! asset('src/js/me.js') !!}"></script>
<script>const baseUrl = window.location.origin;</script>

<!-- Component JAVASCRIPT -->
@if($jquery)
    <script src="{!! asset('src/libs/jquery/jquery.min.js') !!}"></script>
@endif
@if($datatable)
    <script src="{!! asset('src/libs/datatables/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/dataTables.bootstrap5.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/responsive.bootstrap5.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/config.js') !!}"></script>
@endif
@if($datatableButton)
    <script src="{!! asset('src/libs/datatables/js/button/dataTables.buttons.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/buttons.bootstrap5.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/jszip.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/pdfmake.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/vfs_fonts.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/buttons.html5.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/buttons.print.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/button/buttons.colVis.min.js') !!}"></script>
@endif
@if($datatableSelect)
    <script src="{!! asset('src/libs/datatables/js/select/dataTables.select.min.js') !!}"></script>
    <script src="{!! asset('src/libs/datatables/js/select/select.bootstrap5.min.js') !!}"></script>
@endif
@if($datatableRowGroup)
    <script src="{!! asset('src/libs/datatables/js/rowgroup/dataTables.rowGroup.min.js') !!}"></script>
@endif
@if($toastify)
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endif
@if($sweetalert)
    <script src="{!! asset('src/libs/sweetalert2/sweetalert2.min.js') !!}"></script>
@endif
@if($freezeUi)
    <script src="{!! asset('src/libs/freeze-ui/freeze-ui.min.js') !!}"></script>
@endif
@if($select2)
    <script src="{!! asset('src/libs/select2/select2.min.js') !!}"></script>
@endif
@if($flatpickr)
    <script src="{!! asset('src/libs/flatpickr/flatpickr.min.js') !!}"></script>
@endif
@if($dropzone)
    <script src="{!! asset('src/libs/dropzone/dropzone-min.js') !!}"></script>
@endif
@if($cleavejs)
    <script src="{!! asset('src/libs/cleave.js/cleave.min.js') !!}"></script>
    <script src="{!! asset('src/libs/cleave.js/cleave-phone.id.js') !!}"></script>
@endif
@if($glightbox)
    <script src="{!! asset('src/libs/glightbox/js/glightbox.min.js') !!}"></script>
@endif
@yield('script')
<script>
    const btnlogout = document.getElementById('btnlogout');
    btnlogout.onclick = function (){
        url_redirect({
            url     : '{{route('logout')}}',
            method  : "post",
            data    : {"_token" : '{{csrf_token()}}'}
        });
    }
</script>
</body>
</html>
