<!doctype html>
<html lang="en" data-layout="semibox" data-sidebar-visibility="show" data-topbar="dark" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable" data-layout-position="fixed">
<head>
    <meta charset="utf-8">
    <title>{{$title}} | Biensi Fesyenindo RM Manajemen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Biensi Fesyenindo RM Manajemen" name="description"/>
    <meta content="Biensi IT Dept" name="author"/>
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
    <link href="{!! asset('src/css/custom-semibox.min.css') !!}" rel="stylesheet" type="text/css"/>

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
                        <a href="index-2.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{!! asset('src/images/logo/logo-light.png') !!}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{!! asset('src/images/logo/logo-sm-light.png') !!}" alt="" class="logo-height-lg">
                            </span>
                        </a>

                        <a href="index-2.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{!! asset('src/images/logo/logo-light.png') !!}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{!! asset('src/images/logo/logo-sm-light.png') !!}" alt="" class="logo-height-lg">
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
                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{asset('src/images/user-img.jpg')}}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Anna Adame</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome Anna!</h6>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                            <a class="dropdown-item" href="#" id="btnlogout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
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
            <a href="index-2.html" class="logo logo-dark">
               <span class="logo-sm">
                    <img src="{!! asset('src/images/logo/logo-light.png') !!}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{!! asset('src/images/logo/logo-sm-light.png') !!}" alt="" class="logo-height-lg">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="index-2.html" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{!! asset('src/images/logo/logo-light.png') !!}" alt="" class="logo-height-sm">
                </span>
                <span class="logo-lg">
                    <img src="{!! asset('src/images/logo/logo-sm-light.png') !!}" alt="" class="logo-height-lg">
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
                        <a class="nav-link menu-link" href="#sidebarMasterMaterial" data-bs-toggle="collapse" role="button" aria-expanded="{{Route::is('master-rm.*')?'true':'false'}}" aria-controls="sidebarMasterMaterial">
                            <i class="ri-apps-2-line"></i> <span data-key="t-apps">Master Raw Material</span>
                        </a>
                        <div class="collapse menu-dropdown {{Route::is('master-rm.*')?'show':''}}" id="sidebarMasterMaterial">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{!! route('master-rm.fabric.index') !!}" class="nav-link {{Route::is('master-rm.fabric.index')?'active':''}}" data-key="t-fabric"> Jenis Fabric </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('master-rm.komposisi.index') !!}" class="nav-link {{Route::is('master-rm.komposisi.index')?'active':''}}" data-key="t-komposisi"> Komposisi </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('master-rm.raw-material.index') !!}" class="nav-link" data-key="t-aspek"> Raw Material </a>
                                </li>
                            </ul>
                        </div>
                    </li><!-- end Dashboard Menu -->

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarMasterAksesoris" data-bs-toggle="collapse" role="button"
                           aria-expanded="{{Route::is('master-aks.*')?'true':'false'}}" aria-controls="sidebarMasterAksesoris">
                            <i class="ri-pantone-fill"></i> <span
                                data-key="t-authentication">Master Aksesoris</span>
                        </a>
                        <div class="collapse menu-dropdown {{Route::is('master-aks.*')?'show':''}}" id="sidebarMasterAksesoris">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{!! route('master-aks.product-group.index') !!}" class="nav-link {{Route::is('master-aks.product-group.index')?'active':''}}" data-key="t-toko"> Product Group </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('master-aks.aksesoris.index') !!}" class="nav-link {{Route::is('master-aks.aksesoris*')?'active':''}}" data-key="t-region"> Aksesoris </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarMasterWarna" data-bs-toggle="collapse" role="button"
                           aria-expanded="{{Route::is('master-warna.*')?'true':'false'}}" aria-controls="sidebarMasterWarna">
                            <i class="ri-palette-line"></i> <span
                                data-key="t-authentication">Master Warna</span>
                        </a>
                        <div class="collapse menu-dropdown {{Route::is('master-warna.*')?'show':''}}" id="sidebarMasterWarna">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{!! route('master-warna.warna.index') !!}" class="nav-link {{Route::is('master-warna.warna.index')?'active':''}}" data-key="t-warna"> Warna MD </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('master-warna.pantone.index') !!}" class="nav-link {{Route::is('master-warna.pantone.index')?'active':''}}" data-key="t-region"> Pantone </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('master-warna.warna-aksesoris.index') !!}" class="nav-link {{Route::is('master-warna.warna-aksesoris.index')?'active':''}}" data-key="t-region"> Warna Aksesoris </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('brands.index') ? 'active':''}}" href="{!! route('brands.index') !!}" aria-expanded="false">
                            <i class="icon-3second"></i> <span data-key="t-widgets">Brands</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('articles.index') ? 'active':''}}" href="{{route('articles.index')}}" aria-expanded="false">
                            <i class="ri-shirt-fill"></i><span data-ket="t-widgets">Articles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('article-size.index') ? 'active':''}}" href="{{route('article-size.index')}}" aria-expanded="false">
                            <i class="mdi mdi-size-xl fs-21"></i><span data-ket="t-widgets">Article Size</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('supplier*') ? 'active':''}}" href="{!! route('supplier.index') !!}" aria-expanded="false">
                            <i class="mdi mdi-truck-delivery"></i> <span data-key="t-widgets">Supplier</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('measure.index') ? 'active':''}}" href="{{route('measure.index')}}" aria-expanded="false">
                            <i class="mdi mdi-tape-measure"></i> <span data-key="t-widgets">Unit of Measure</span>
                        </a>
                    </li>
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Bill of Material</span>
                    </li>

                    <a class="nav-link menu-link {{Route::is('bom.index') ? 'active':''}}" href="{{route('bom.index')}}" aria-expanded="false">
                        <i class="ri-book-read-line"></i><span data-ket="t-widgets">BOM</span>
                    </a>
                    @role('Super Admin')
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">User Management</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('role.index')?'active':''}}" href="{{route('role.index')}}" aria-expanded="false">
                            <i class="ri-team-fill"></i> <span data-key="t-widgets">Role</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{Route::is('permission.index')?'active':''}}" href="{{route('permission.index')}}" aria-expanded="false">
                            <i class="ri-spy-line"></i> <span data-key="t-widgets">Permission</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('measure.index')}}" aria-expanded="false">
                            <i class="ri-shield-user-line"></i> <span data-key="t-widgets">User</span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="mb-0">
                    <div class="row">
                        <div class="col-12">
                            {{--Start Page Title--}}
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                {!! \Diglactic\Breadcrumbs\Breadcrumbs::render($breadcrumbs) !!}
                            </div>
                            {{--End Page Title--}}
                        </div> <!-- end col -->
                    </div>
                    {{$slot}}
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
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
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

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
@if($jsvalidation)
<script src="{!! asset('vendor/jsvalidation/js/jsvalidation.min.js') !!}"></script>
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
