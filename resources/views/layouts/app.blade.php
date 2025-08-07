<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?> dir="rtl" <?php } ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title id="app_name"><?php echo @$_COOKIE['meta_title']; ?></title>
    <link rel="icon" id="favicon" type="image/x-icon"
          href="<?php echo str_replace('images/', 'images%2F', @$_COOKIE['favicon']); ?>">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Styles -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?>
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?>
    <link href="{{asset('css/style_rtl.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{ asset('css/icons/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <link href="{{ asset('css/colors/blue.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <!-- Enhanced Notification Bell Styles -->
    <style>
        .nav-item .fa-bell {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-item .fa-bell:hover {
            color: #ff6849 !important;
            transform: scale(1.1);
        }

        .badge-counter {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .toast-notification {
            z-index: 9999;
        }

        /* Enhanced Notification Container */
        #notification-container {
            position: relative;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
        }

        .notification-bell:hover {
            color: #ff6849 !important;
        }

        /* Custom Tooltip Styles */
        .notification-tooltip-content {
            position: absolute;
            top: 100%;
            right: 0;
            width: 300px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            margin-top: 5px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .notification-tooltip-content.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-tooltip-content::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 15px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
        }

        .tooltip-header {
            background: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            color: #333;
        }

        .tooltip-header i {
            margin-right: 8px;
            color: #ff6849;
        }

        .tooltip-body {
            max-height: 200px;
            overflow-y: auto;
            padding: 0;
        }

        .recent-order-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .recent-order-item:hover {
            background-color: #f8f9fa;
        }

        .recent-order-item:last-child {
            border-bottom: none;
        }

        .order-id {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .order-customer {
            color: #666;
            font-size: 12px;
            margin-top: 2px;
        }

        .order-time {
            color: #999;
            font-size: 11px;
            margin-top: 2px;
        }

        .no-orders {
            padding: 20px 15px;
            text-align: center;
            color: #999;
            font-style: italic;
        }

        /* Sound notification indicator */
        .sound-indicator {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: soundPulse 1s infinite;
        }

        @keyframes soundPulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Notification sound controls */
        .sound-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
        }

        .sound-controls.show {
            display: block;
        }

        .sound-toggle {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .sound-toggle:hover {
            background: #f0f0f0;
            color: #333;
        }

        .sound-toggle.muted {
            color: #dc3545;
        }
    </style>

    <?php if (isset($_COOKIE['admin_panel_color'])) { ?>

    <style type="text/css">


        .sidebar-nav ul li a {
            border-bottom: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .sidebar-nav ul li a:hover i {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .vendor_payout_create-inner fieldset legend {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .restaurant_payout_create-inner fieldset legend {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        a {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        a:hover, a:focus {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        a.link:hover, a.link:focus {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        html body blockquote {
            border-left: 5px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .text-warning {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
        }

        .text-info {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
        }

        .sidebar-nav ul li a:hover {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .btn-primary {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border: 1px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .sidebar-nav > ul > li.active > a,.sidebar-nav ul li ul li.active a,.sidebar-nav ul li ul li a:hover {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-right: 3px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .sidebar-nav > ul > li.active > a i {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .bg-info {
            background-color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
        }

        .bellow-text ul li > span {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>


        }

        .table tr td.redirecttopage {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>


        }

        ul.rating {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .nav-tabs.card-header-tabs .nav-link.active, .nav-tabs.card-header-tabs .nav-link:hover {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?> <?php    echo $_COOKIE['admin_panel_color']; ?> #fff;
        }

        .btn-warning, .btn-warning.disabled {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border: 1px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
            box-shadow: none;
        }

        .payment-top-tab .nav-tabs.card-header-tabs .nav-link.active, .payment-top-tab .nav-tabs.card-header-tabs .nav-link:hover {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .nav-tabs.card-header-tabs .nav-link span.badge-success {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .nav-tabs.card-header-tabs .nav-link.active span.badge-success, .nav-tabs.card-header-tabs .nav-link:hover span.badge-success, .sidebar-nav ul li a.active, .sidebar-nav ul li a.active:hover, .sidebar-nav ul li.active a.has-arrow:hover, .topbar ul.dropdown-user li a:hover {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .sidebar-nav ul li a.has-arrow:hover::after, .sidebar-nav .active > .has-arrow::after, .sidebar-nav li > .has-arrow.active::after, .sidebar-nav .has-arrow[aria-expanded="true"]::after, .sidebar-nav ul li a:hover {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        [type="checkbox"]:checked + label::before {
            border-right: 2px solid <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-bottom: 2px solid <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .edit-form-group .form-check [type="checkbox"]:checked + label::after{border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;background: <?php    echo $_COOKIE['admin_panel_color']; ?>}

        .btn-primary:hover, .btn-primary.disabled:hover {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border: 1px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .btn-primary.active, .btn-primary:active, .btn-primary:focus, .btn-primary.disabled.active, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary.focus:active, .btn-primary:active:focus, .btn-primary:active:hover, .open > .dropdown-toggle.btn-primary.focus, .open > .dropdown-toggle.btn-primary:focus, .open > .dropdown-toggle.btn-primary:hover, .btn-primary.focus, .btn-primary:focus, .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show > .btn-primary.dropdown-toggle:focus, .btn-warning:hover, .btn-warning:hover, .btn-warning.disabled:hover, .btn-warning.active.focus, .btn-warning.active:focus, .btn-warning.active:hover, .btn-warning.focus:active, .btn-warning:active:focus, .btn-warning:active:hover, .open > .dropdown-toggle.btn-warning.focus, .open > .dropdown-toggle.btn-warning:focus, .open > .dropdown-toggle.btn-warning:hover, .btn-warning.focus, .btn-warning:focus {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            box-shadow: 0 0 0 0.2rem<?php    echo $_COOKIE['admin_panel_color']; ?>;
            color: #fff;
        }

        .pagination > li > a.page-link:hover {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .mini-sidebar .sidebar-nav #sidebarnav > li:hover a i, .mini-sidebar .sidebar-nav ul li a, .sidebar-nav ul li a.active i, .sidebar-nav ul li a.active:hover i, .sidebar-nav ul li.active a:hover i {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider .cat-item a.cat-link:hover, .cat-slider .cat-item.section-selected a.cat-link {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider .cat-item a.cat-link {
            border-bottom-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider .cat-item.section-selected a.cat-link:after {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .business-analytics .card-box i {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .order-status .data i, .order-status span.count {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .print-btn button {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        [type="radio"]:checked + label::after, [type="radio"].with-gap:checked + label::after {background-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;}
        [type="radio"]:checked + label::after, [type="radio"].with-gap:checked + label::before, [type="radio"].with-gap:checked + label::after {border: 2px solid <?php    echo $_COOKIE['admin_panel_color']; ?>;}

        .card-header-tab ul.nav-tab li.active a,.card-header-tab ul.nav-tab li a:hover{background: <?php echo $_COOKIE['admin_panel_color']; ?>;}
        .edit-form-group .form-check [type="radio"]:checked + label::before,.edit-form-group .form-check [type="checkbox"]:checked + label::after {background: <?php echo $_COOKIE['admin_panel_color']; ?>; border-color: <?php echo $_COOKIE['admin_panel_color']; ?>;}
        .pricing-card-btm .btn:hover{background: <?php echo $_COOKIE['admin_panel_color']; ?>;border-color: <?php echo $_COOKIE['admin_panel_color']; ?>;}
        @media screen and ( max-width: 767px ) {

            .mini-sidebar .sidebar-nav ul li a:hover, .sidebar-nav > ul > li.active > a {
                color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
            }

            .mini-sidebar .sidebar-nav #sidebarnav > li:hover a i, .mini-sidebar .sidebar-nav ul li a, .sidebar-nav ul li a.active i, .sidebar-nav ul li a.active:hover i, .sidebar-nav ul li.active a:hover i {
                color: #fff;
            }

            .sidebar-nav > ul > li.active > a, .sidebar-nav > ul > li.active > a i, .sidebar-nav > ul > li > a:hover i {
                color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
            }
        }
    </style>
    <?php } ?>

</head>
<body>

<div id="app" class="fix-header fix-sidebar card-no-border">
    <div id="main-wrapper">
        <div id="data-table_processing" class="page-overlay" style="display:none;">
            <div class="overlay-text">
                <img src="{{asset('images/spinner.gif')}}">
            </div>
        </div>
        <header class="topbar">

            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                @include('layouts.header')
            </nav>

        </header>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                @include('layouts.menu')
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
</div>

<!-- Sound Controls -->
<div class="sound-controls" id="sound-controls">
    <button class="sound-toggle" id="sound-toggle" title="Toggle Sound Notifications">
        <i class="fa fa-volume-up"></i>
    </button>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.7.3/leaflet.editable.min.js"></script>
<script src="https://unpkg.com/leaflet-draw@0.4.14/dist/leaflet.draw-src.js"></script>
<script src="https://unpkg.com/leaflet-geojson-layer/src/leaflet.geojson.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.js')}}"></script>

<script src="{{ asset('js/jquery.resizeImg.js') }}"></script>
<script src="{{ asset('js/mobileBUGFix.mini.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script type="text/javascript">
    jQuery(window).scroll(function () {
        var scroll = jQuery(window).scrollTop();
        if (scroll <= 60) {
            jQuery("body").removeClass("sticky");
        } else {
            jQuery("body").addClass("sticky");
        }
    });

</script>
<script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-database.js"></script>
<script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>
<script src="https://cdn.firebase.com/libs/geofire/5.0.1/geofire.min.js"></script>
<script src="{{ asset('js/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="{{ asset('js/jquery.masking.js') }}"></script>
<script src="{{ asset('assets/plugins/toast-master/js/jquery.toast.js') }}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">

    var database = firebase.firestore();
    var geoFirestore = new GeoFirestore(database);
    var createdAtman = firebase.firestore.Timestamp.fromDate(new Date());
    var createdAt = {_nanoseconds: createdAtman.nanoseconds, _seconds: createdAtman.seconds};

    var ref = database.collection('settings').doc("globalSettings");
    ref.get().then(async function (snapshots) {
        try {
            var globalSettings = snapshots.data();
            $("#logo_web").attr('src', globalSettings.appLogo);

            if (getCookie('meta_title') == undefined || getCookie('meta_title') == null || getCookie('meta_title') == "") {
                document.title = globalSettings.meta_title;

                setCookie('meta_title', globalSettings.meta_title, 365);
            }

        } catch (error) {

        }
    });
    var refDistance = database.collection('settings').doc("RestaurantNearBy");
    refDistance.get().then(async function (snapshots) {
        try {
            var data = snapshots.data();
            var distanceType=data.distanceType.charAt(0).toUpperCase() + data.distanceType.slice(1);
            $('#distanceType').val(distanceType);
            $('.global_distance_type').html(distanceType);

        } catch (error) {

        }
    });


    var langcount = 0;
    var languages_list = database.collection('settings').doc('languages');
    languages_list.get().then(async function (snapshotslang) {
        snapshotslang = snapshotslang.data();
        if (snapshotslang != undefined) {
            snapshotslang = snapshotslang.list;
            languages_list_main = snapshotslang;
            snapshotslang.forEach((data) => {
                if (data.isActive == true) {
                    langcount++;
                    $('#language_dropdown').append($("<option></option>").attr("value", data.slug).text(data.title));
                }
            });
            if (langcount > 1) {
                $("#language_dropdown_box").css('visibility', 'visible');
            }
            <?php if (session()->get('locale')) { ?>
            $("#language_dropdown").val("<?php    echo session()->get('locale'); ?>");
            <?php } ?>

        }
    });

    var url = "{{ route('changeLang') }}";

    $(".changeLang").change(function () {
        var slug = $(this).val();
        languages_list_main.forEach((data) => {
            if (slug == data.slug) {
                if (data.is_rtl == undefined) {
                    setCookie('is_rtl', 'false', 365);
                } else {
                    setCookie('is_rtl', data.is_rtl.toString(), 365);
                }
                window.location.href = url + "?lang=" + slug;
            }
        });
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    var version = database.collection('settings').doc("Version");
    version.get().then(async function (snapshots) {
        var version_data = snapshots.data();
        if (version_data == undefined) {
            database.collection('settings').doc('Version').set({});
        }
        try {
            $('.web_version').html("V:" + version_data.web_version);
        } catch (error) {
        }
    });

    async function sendEmail(url, subject, message, recipients) {

        var checkFlag = false;

        await $.ajax({

            type: 'POST',
            data: {
                subject: subject,
                message: message,
                recipients: recipients
            },
            url: url,
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                checkFlag = true;
            },
            error: function (xhr, status, error) {
                checkFlag = true;
            }
        });

        return checkFlag;

    }
    function exportData(dt, format, config) {
        const {
            columns,
            fileName = 'Export',
        } = config;

        const filteredRecords = dt.ajax.json().filteredData;

        const fieldTypes = {};
        const dataMapper = (record) => {
            return columns.map((col) => {
                const value = record[col.key];
                if (!fieldTypes[col.key]) {
                    if (value === true || value === false) {
                        fieldTypes[col.key] = 'boolean';
                    } else if (value && typeof value === 'object' && value.seconds) {
                        fieldTypes[col.key] = 'date';
                    } else if (typeof value === 'number') {
                        fieldTypes[col.key] = 'number';
                    } else if (typeof value === 'string') {
                        fieldTypes[col.key] = 'string';
                    } else {
                        fieldTypes[col.key] = 'string';
                    }
                }

                switch (fieldTypes[col.key]) {
                    case 'boolean':
                        return value ? 'Yes' : 'No';
                    case 'date':
                        return value ? new Date(value.seconds * 1000).toLocaleString() : '-';
                    case 'number':
                        return typeof value === 'number' ? value : 0;
                    case 'string':
                    default:
                        return value || '-';
                }
            });
        };

        const tableData = filteredRecords.map(dataMapper);

        const data = [columns.map(col => col.header), ...tableData];

        const columnWidths = columns.map((_, colIndex) =>
            Math.max(...data.map(row => row[colIndex]?.toString().length || 0))
        );

        if (format === 'csv') {
            const csv = data.map(row => row.map(cell => {
                if (typeof cell === 'string' && (cell.includes(',') || cell.includes('\n') || cell.includes('"'))) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }
                return cell;
            }).join(',')).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            saveAs(blob, `${fileName}.csv`);
        } else if (format === 'excel') {
            const ws = XLSX.utils.aoa_to_sheet(data, { cellDates: true });

            ws['!cols'] = columnWidths.map(width => ({ wch: Math.min(width + 5, 30) }));

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Data');
            XLSX.writeFile(wb, `${fileName}.xlsx`);
        } else if (format === 'pdf') {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const totalLength = columnWidths.reduce((sum, length) => sum + length, 0);
            const columnStyles = {};
            columnWidths.forEach((length, index) => {
                columnStyles[index] = {
                    cellWidth: (length / totalLength) * 180,
                };
            });

            doc.setFontSize(16);
            doc.text(fileName, 14, 16);

            doc.autoTable({
                head: [columns.map(col => col.header)],
                body: tableData,
                startY: 20,
                theme: 'striped',
                styles: {
                    cellPadding: 2,
                    fontSize: 10,
                },
                columnStyles,
                margin: { top: 30, bottom: 30 },
                didDrawPage: function (data) {
                    doc.setFontSize(10);
                    doc.text(fileName, data.settings.margin.left, 10);
                }
            });
            doc.save(`${fileName}.pdf`);
        } else {
            console.error('Unsupported format');
        }
    }


    var mapType = 'ONLINE';
    database.collection('settings').doc('DriverNearBy').get().then(async function (snapshots) {
        var data = snapshots.data();
        if (data && data.selectedMapType && data.selectedMapType == "osm") {
            mapType = "OFFLINE"
        }
    });

    async function loadGoogleMapsScript() {
        var googleMapKeySnapshotsHeader = await database.collection('settings').doc("googleMapKey").get();
        var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
        googleMapKey = placeholderImageHeaderData.key;
        const script = document.createElement('script');
        if (mapType == "OFFLINE" ){
            script.src = "https://unpkg.com/leaflet@1.7.1/dist/leaflet.js";
            script.src = "https://unpkg.com/leaflet-draw/dist/leaflet.draw.js";
            script.src = "https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.7.3/leaflet.editable.min.js";
            script.src = "https://unpkg.com/leaflet-draw@0.4.14/dist/leaflet.draw-src.js";
            script.src = "https://unpkg.com/leaflet-ajax/dist/leaflet.ajax.min.js";
            script.src = "https://unpkg.com/leaflet-geojson-layer/src/leaflet.geojson.js";
            script.src = "https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js";

        }else{
            script.src = "https://maps.googleapis.com/maps/api/js?key=" + googleMapKey + "&libraries=places,drawing";
        }
        script.onload = function () {
            navigator.geolocation.getCurrentPosition(GeolocationSuccessCallback,GeolocationErrorCallback);
            if(typeof window['InitializeGodsEyeMap'] === 'function') {
                InitializeGodsEyeMap();
            }
        };
        document.head.appendChild(script);
    }

    const GeolocationSuccessCallback = (position) => {
        if(position.coords != undefined){
            default_latitude = position.coords.latitude
            default_longitude = position.coords.longitude
            setCookie('default_latitude', default_latitude, 365);
            setCookie('default_longitude', default_longitude, 365);
        }
    };

    const GeolocationErrorCallback = (error) => {
        console.log('Error: You denied for your default Geolocation',error.message);
        setCookie('default_latitude', '23.022505', 365);
        setCookie('default_longitude','72.571365', 365);
    };

    loadGoogleMapsScript();

    async function sendNotification(fcmToken = '', title, body) {
        var checkFlag = false;
        var sendNotificationUrl = "{{ route('send-notification') }}";

        if (fcmToken !== '') {
            await $.ajax({
                type: 'POST',
                url: sendNotificationUrl,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'fcm': fcmToken,
                    'title': title,
                    'message': body
                },
                success: function (data) {
                    checkFlag = true;
                },
                error: function (error) {
                    checkFlag = true;
                }
            });
        } else {
            checkFlag = true;
        }

        return checkFlag;
    }

    database.collection('settings').doc("notification_setting").get().then(async function (snapshots) {
        var data = snapshots.data();
        if(data != undefined){
            serviceJson = data.serviceJson;
            if(serviceJson != '' && serviceJson != null){
                $.ajax({
                    type: 'POST',
                    data: {
                        serviceJson: btoa(serviceJson),
                    },
                    url: "{{ route('store-firebase-service') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                    }
                });
            }
        }
    });

         //On delete item delete image also from bucket general code
         const deleteDocumentWithImage = async (collection, id, singleImageField, arrayImageField) => {
            // Reference to the Firestore document
            const docRef = database.collection(collection).doc(id);
            try {
                const doc = await docRef.get();
                if (!doc.exists) {
                    console.log("No document found for deletion");
                    return;
                }

                const data = doc.data();

                // Deleting single image field
                if (singleImageField) {
                    if (Array.isArray(singleImageField)) {
                        for (const field of singleImageField) {
                            const imageUrl = data[field];
                            if (imageUrl) await deleteImageFromBucket(imageUrl);
                        }
                    } else {
                        const imageUrl = data[singleImageField];
                        if (imageUrl) await deleteImageFromBucket(imageUrl);
                    }
                }
                // Deleting array image field
                if (arrayImageField) {
                    if (Array.isArray(arrayImageField)) {
                        for (const field of arrayImageField) {
                            const arrayImages = data[field];
                            if (arrayImages && Array.isArray(arrayImages)) {
                                for (const imageUrl of arrayImages) {
                                    if (imageUrl) await deleteImageFromBucket(imageUrl);
                                }
                            }
                        }
                    } else {
                        const arrayImages = data[arrayImageField];
                        if (arrayImages && Array.isArray(arrayImages)) {
                            for (const imageUrl of arrayImages) {
                                if (imageUrl) await deleteImageFromBucket(imageUrl);
                            }
                        }
                    }
                }

                 // Deleting images in variants array within item_attribute
                const item_attribute = data.item_attribute || {};  // Access item_attribute
                const variants = item_attribute.variants || [];    // Access variants array inside item_attribute
                if (variants.length > 0) {
                    for (const variant of variants) {
                        const variantImageUrl = variant.variant_image;
                        if (variantImageUrl) {
                            await deleteImageFromBucket(variantImageUrl);
                        }
                    }
                }

                // Optionally delete the Firestore document after image deletion
                await docRef.delete();
                console.log("Document and images deleted successfully.");
            } catch (error) {
                console.error("Error deleting document and images:", error);
            }
        };

    const deleteImageFromBucket = async (imageUrl) => {
        try {
            const storageRef = firebase.storage().ref();

            // Check if the imageUrl is a full URL or just a child path
            let oldImageUrlRef;
            if (imageUrl.includes('https://')) {
                // Full URL
                oldImageUrlRef = storageRef.storage.refFromURL(imageUrl);
            } else {
                // Child path, use ref instead of refFromURL
                oldImageUrlRef = storageRef.storage.ref(imageUrl);
            }
            var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";
            var imageBucket = oldImageUrlRef.bucket;
            // Check if the bucket name matches
            if (imageBucket === envBucket) {
                // Delete the image
                await oldImageUrlRef.delete();
                console.log("Image deleted successfully.");
            }
        } catch (error) {

        }
    };

                         // Enhanced Global Real-time Order Notification System
         (function() {
             // Initialize enhanced notification system
             let knownOrderIds = new Set();
             let pageLoadTime = Date.now();
             let isInitialized = false;
             let notificationSound = null;
             let customRingtone = null;
             let soundEnabled = localStorage.getItem('notificationSoundEnabled') !== 'false';
             let recentOrders = [];
             let tooltipTimeout = null;

             // Load custom ringtone from global settings
             function loadCustomRingtone() {
                 const settingsRef = database.collection('settings').doc('globalSettings');
                 settingsRef.get().then((snapshot) => {
                     const globalSettings = snapshot.data();
                     if (globalSettings && globalSettings.order_ringtone_url) {
                         customRingtone = globalSettings.order_ringtone_url;
                         console.log('Custom ringtone loaded:', customRingtone);
                     }
                 }).catch((error) => {
                     console.log('Error loading custom ringtone:', error);
                 });
             }

             // Create notification sound
             function createNotificationSound() {
                 if (!notificationSound) {
                     // Use custom ringtone if available
                     if (customRingtone) {
                         notificationSound = new Audio(customRingtone);
                         notificationSound.volume = 0.5;
                         console.log('Using custom ringtone for notifications');
                     } else {
                         // Create a pleasant notification sound using Web Audio API
                         try {
                             const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                             const oscillator = audioContext.createOscillator();
                             const gainNode = audioContext.createGain();

                             oscillator.connect(gainNode);
                             gainNode.connect(audioContext.destination);

                             oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                             oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
                             oscillator.frequency.setValueAtTime(800, audioContext.currentTime + 0.2);

                             gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                             gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);

                             oscillator.start(audioContext.currentTime);
                             oscillator.stop(audioContext.currentTime + 0.3);

                             notificationSound = { audioContext, oscillator, gainNode };
                         } catch (e) {
                             console.log('Web Audio API not supported, using fallback sound');
                             // Fallback to simple beep
                             notificationSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
                             notificationSound.volume = 0.3;
                         }
                     }
                 }
             }

             // Play notification sound
             function playNotificationSound() {
                 if (!soundEnabled) return;

                 createNotificationSound();

                 try {
                     if (customRingtone && notificationSound.src) {
                         // Custom ringtone audio
                         notificationSound.currentTime = 0;
                         notificationSound.play().catch(e => console.log('Custom ringtone play failed:', e));
                     } else if (notificationSound.audioContext) {
                         // Web Audio API sound
                         const audioContext = notificationSound.audioContext;
                         const oscillator = audioContext.createOscillator();
                         const gainNode = audioContext.createGain();

                         oscillator.connect(gainNode);
                         gainNode.connect(audioContext.destination);

                         oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                         oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
                         oscillator.frequency.setValueAtTime(800, audioContext.currentTime + 0.2);

                         gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                         gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);

                         oscillator.start(audioContext.currentTime);
                         oscillator.stop(audioContext.currentTime + 0.3);
                     } else {
                         // Fallback audio
                         notificationSound.currentTime = 0;
                         notificationSound.play().catch(e => console.log('Audio play failed:', e));
                     }
                 } catch (e) {
                     console.log('Sound play failed:', e);
                 }
             }

             let toastOffset = 0;

             function showNewOrderNotification(orderData) {
                 playNotificationSound();

                 // Fallback: Check for toast plugin
                 if (typeof Swal === 'undefined') {
                     console.error('SweetAlert not loaded!');
                     alert(`New Order: #${orderData.id}`);
                     return;
                 }

                 // Create a unique wrapper per toast
                 const wrapper = document.createElement('div');
                 wrapper.style.marginTop = `${toastOffset}px`;
                 document.getElementById('toast-container').appendChild(wrapper);

                 Swal.fire({
                     title: 'New Order Received!',
                     html: `<strong>Order #${orderData.id}</strong><br>From: ${orderData.vendor ? orderData.vendor.title : 'Restaurant'}`,
                     icon: 'info',
                     toast: true,
                     position: 'top',
                     showConfirmButton: false,
                     showCloseButton: true,
                     timer: 10000,
                     timerProgressBar: true,
                     target: wrapper,
                     didOpen: (toast) => {
                         toast.addEventListener('click', () => {
                             window.location.href = '{{ route("orders") }}';
                         });
                     },
                     willClose: () => {
                         wrapper.remove();
                         toastOffset -= 90; // adjust spacing after toast disappears
                     }
                 });

                 toastOffset += 90; // adjust spacing for next toast (approx height)

                 // Optional: reset offset if too many
                 if (toastOffset > 500) toastOffset = 0;

                 updateOrderCount();
                 updateNotificationBadge();
                 addToRecentOrders(orderData);
             }
             // Add order to recent orders list
             function addToRecentOrders(orderData) {
                 const orderInfo = {
                     id: orderData.id,
                     customer: orderData.author ? orderData.author.name : 'Unknown Customer',
                     vendor: orderData.vendor ? orderData.vendor.title : 'Restaurant',
                     time: new Date(),
                     total: orderData.toPayAmount || 0
                 };

                 recentOrders.unshift(orderInfo);

                 // Keep only last 3 orders
                 if (recentOrders.length > 3) {
                     recentOrders = recentOrders.slice(0, 3);
                 }

                 // Update tooltip content
                 updateTooltipContent();
             }

             // Update tooltip content
             function updateTooltipContent() {
                 const tooltipBody = document.getElementById('recent-orders-tooltip');
                 if (!tooltipBody) return;

                 if (recentOrders.length === 0) {
                     tooltipBody.innerHTML = '<div class="no-orders">No recent orders</div>';
                     return;
                 }

                 let html = '';
                 recentOrders.forEach(order => {
                     const timeAgo = getTimeAgo(order.time);
                     html += `
                         <div class="recent-order-item">
                             <div class="order-id">Order #${order.id}</div>
                             <div class="order-customer">${order.customer} • ${order.vendor}</div>
                             <div class="order-time">${timeAgo} • $${order.total.toFixed(2)}</div>
                         </div>
                     `;
                 });

                 tooltipBody.innerHTML = html;
             }

             // Get time ago string
             function getTimeAgo(date) {
                 const now = new Date();
                 const diffMs = now - date;
                 const diffMins = Math.floor(diffMs / 60000);
                 const diffHours = Math.floor(diffMs / 3600000);
                 const diffDays = Math.floor(diffMs / 86400000);

                 if (diffMins < 1) return 'Just now';
                 if (diffMins < 60) return `${diffMins}m ago`;
                 if (diffHours < 24) return `${diffHours}h ago`;
                 return `${diffDays}d ago`;
             }

             // Update order count on dashboard
             function updateOrderCount() {
                 database.collection('restaurant_orders').get().then((snapshot) => {
                     const orderCount = snapshot.docs.length;
                     const orderCountElement = document.getElementById('order_count');
                     if (orderCountElement) {
                         orderCountElement.textContent = orderCount;
                     }
                 });
             }

             // Update notification badge
             function updateNotificationBadge() {
                 const badge = document.getElementById('new-orders-badge');
                 if (badge) {
                     const currentCount = parseInt(badge.textContent) || 0;
                     const newCount = currentCount + 1;
                     badge.textContent = newCount;
                     badge.style.display = 'block';

                     // Auto-hide badge after 30 seconds
                     setTimeout(() => {
                         badge.style.display = 'none';
                         badge.textContent = '0';
                     }, 30000);
                 }
             }

             // Initialize real-time listener for new orders
             function initializeOrderListener() {
                 console.log('Initializing enhanced global order notification listener...');

                 // Get existing orders to populate knownOrderIds and recent orders
                 database.collection('restaurant_orders')
                     .orderBy('createdAt', 'desc')
                     .limit(50) // Get last 50 orders
                     .get()
                     .then((snapshot) => {
                         if (!snapshot.empty) {
                             snapshot.docs.forEach(doc => {
                                 knownOrderIds.add(doc.id);
                             });
                             console.log('Known order IDs populated:', knownOrderIds.size, 'orders');

                             // Populate recent orders for tooltip
                             snapshot.docs.slice(0, 5).forEach(doc => {
                                 const orderData = doc.data();
                                 addToRecentOrders({
                                     id: doc.id,
                                     author: orderData.author,
                                     vendor: orderData.vendor,
                                     toPayAmount: orderData.toPayAmount
                                 });
                             });
                         } else {
                             console.log('No existing orders found, will show notifications for all new orders');
                         }

                         // Start real-time listener
                         startRealtimeListener();
                     })
                     .catch((error) => {
                         console.error('Error getting existing orders:', error);
                         // Start listener anyway
                         startRealtimeListener();
                     });
             }

             // Start real-time listener
             function startRealtimeListener() {
                 console.log('Starting enhanced real-time listener for restaurant_orders collection...');
                 const ordersRef = database.collection('restaurant_orders');

                 // Listen for new documents
                 ordersRef.onSnapshot((snapshot) => {
                     console.log('Snapshot received, changes:', snapshot.docChanges().length);

                     snapshot.docChanges().forEach((change) => {
                         console.log('Change type:', change.type, 'Document ID:', change.doc.id);

                         if (change.type === 'added') {
                             const orderData = change.doc.data();
                             orderData.id = change.doc.id;

                             console.log('Order change detected:', change.type, orderData.id, orderData.createdAt);

                             // Check if this is a truly new order
                             if (!knownOrderIds.has(orderData.id)) {
                                 // This is a new order we haven't seen before
                                 console.log('New order detected (ID not in known set):', orderData.id);

                                 // Only show notification if system is initialized (to avoid showing old orders on page load)
                                 if (isInitialized) {
                                     showNewOrderNotification(orderData);
                                 }

                                 // Add to known orders
                                 knownOrderIds.add(orderData.id);
                             } else {
                                 console.log('Order already known (ID in known set):', orderData.id);
                             }
                         }
                     });

                     // Mark as initialized after first snapshot
                     if (!isInitialized) {
                         isInitialized = true;
                         console.log('Enhanced notification system initialized, will show notifications for new orders');
                     }
                 }, (error) => {
                     console.error('Error in order listener:', error);
                     // Retry after 5 seconds
                     setTimeout(initializeOrderListener, 5000);
                 });
             }

             // Initialize tooltip functionality
             function initializeTooltip() {
                 const notificationBell = document.querySelector('.notification-bell');
                 const tooltipContent = document.querySelector('.notification-tooltip-content');

                 if (!notificationBell || !tooltipContent) return;

                 // Show tooltip on hover
                 notificationBell.addEventListener('mouseenter', () => {
                     if (tooltipTimeout) {
                         clearTimeout(tooltipTimeout);
                     }
                     tooltipContent.classList.add('show');
                 });

                 // Hide tooltip on mouse leave
                 notificationBell.addEventListener('mouseleave', () => {
                     tooltipTimeout = setTimeout(() => {
                         tooltipContent.classList.remove('show');
                     }, 300);
                 });

                 // Prevent tooltip from hiding when hovering over it
                 tooltipContent.addEventListener('mouseenter', () => {
                     if (tooltipTimeout) {
                         clearTimeout(tooltipTimeout);
                     }
                 });

                 tooltipContent.addEventListener('mouseleave', () => {
                     tooltipContent.classList.remove('show');
                 });
             }

             // Initialize sound controls
             function initializeSoundControls() {
                 const soundToggle = document.getElementById('sound-toggle');
                 const soundControls = document.getElementById('sound-controls');

                 if (!soundToggle) return;

                 // Show sound controls after first notification
                 let controlsShown = false;

                 // Load sound preference from localStorage
                 const savedSoundPreference = localStorage.getItem('notificationSoundEnabled');
                 if (savedSoundPreference !== null) {
                     soundEnabled = savedSoundPreference === 'true';
                     updateSoundToggleIcon();
                 }

                 soundToggle.addEventListener('click', () => {
                     soundEnabled = !soundEnabled;
                     localStorage.setItem('notificationSoundEnabled', soundEnabled.toString());
                     updateSoundToggleIcon();

                     // Show controls if not shown yet
                     if (!controlsShown) {
                         soundControls.classList.add('show');
                         controlsShown = true;

                         // Hide after 5 seconds
                         setTimeout(() => {
                             soundControls.classList.remove('show');
                         }, 5000);
                     }
                 });

                 function updateSoundToggleIcon() {
                     const icon = soundToggle.querySelector('i');
                     if (soundEnabled) {
                         icon.className = 'fa fa-volume-up';
                         soundToggle.classList.remove('muted');
                         soundToggle.title = 'Mute Sound Notifications';
                     } else {
                         icon.className = 'fa fa-volume-off';
                         soundToggle.classList.add('muted');
                         soundToggle.title = 'Unmute Sound Notifications';
                     }
                 }

                 updateSoundToggleIcon();
             }

             // Initialize the enhanced notification system when DOM is ready
             $(document).ready(function() {
                 // Load custom ringtone first
                 loadCustomRingtone();

                 // Small delay to ensure Firebase is fully initialized
                 setTimeout(() => {
                     initializeOrderListener();
                     initializeTooltip();
                     initializeSoundControls();
                 }, 1000);

                 // Add debug info to console
                 setTimeout(() => {
                     console.log('=== ENHANCED NOTIFICATION SYSTEM DEBUG INFO ===');
                     console.log('Firebase database object:', typeof database !== 'undefined' ? 'Available' : 'Not available');
                     console.log('jQuery toast plugin:', typeof $.toast !== 'undefined' ? 'Available' : 'Not available');
                     console.log('Sound enabled:', soundEnabled);
                     console.log('Recent orders count:', recentOrders.length);

                     // Test toast plugin if available
                     if (typeof $.toast !== 'undefined') {
                         console.log('Toast plugin is working!');
                     } else {
                         console.error('Toast plugin is NOT loaded!');
                     }
                     console.log('===============================================');
                 }, 2000);
             });

             // Clear notification badge
             function clearNotificationBadge() {
                 const badge = document.getElementById('new-orders-badge');
                 if (badge) {
                     badge.style.display = 'none';
                     badge.textContent = '0';
                 }
             }

             // Clear badge when user visits orders page
             $(document).ready(function() {
                 if (window.location.pathname.includes('/orders')) {
                     clearNotificationBadge();
                 }
             });

             // Make functions globally available for debugging and testing
             window.orderNotificationSystem = {
                 initializeOrderListener: initializeOrderListener,
                 showNewOrderNotification: showNewOrderNotification,
                 updateOrderCount: updateOrderCount,
                 clearNotificationBadge: clearNotificationBadge,
                 playNotificationSound: playNotificationSound,
                 refreshCustomRingtone: loadCustomRingtone,
                 toggleSound: function() {
                     soundEnabled = !soundEnabled;
                     localStorage.setItem('notificationSoundEnabled', soundEnabled.toString());
                     const soundToggle = document.getElementById('sound-toggle');
                     if (soundToggle) {
                         const icon = soundToggle.querySelector('i');
                         if (soundEnabled) {
                             icon.className = 'fa fa-volume-up';
                             soundToggle.classList.remove('muted');
                         } else {
                             icon.className = 'fa fa-volume-off';
                             soundToggle.classList.add('muted');
                         }
                     }
                 },
                 testNotification: function() {
                     const testOrderData = {
                         id: 'TEST_' + Date.now(),
                         vendor: { title: 'Test Restaurant' },
                         author: { name: 'Test Customer' },
                         toPayAmount: 25.00,
                         status: 'Order Placed'
                     };
                     showNewOrderNotification(testOrderData);
                 },
                 testCustomRingtone: function() {
                     if (customRingtone) {
                         const audio = new Audio(customRingtone);
                         audio.volume = 0.5;
                         audio.play().catch(e => console.log('Custom ringtone test failed:', e));
                         console.log('Testing custom ringtone:', customRingtone);
                     } else {
                         console.log('No custom ringtone available');
                     }
                 },
                 getDebugInfo: function() {
                     return {
                         knownOrderIds: Array.from(knownOrderIds),
                         knownOrderCount: knownOrderIds.size,
                         isInitialized: isInitialized,
                         pageLoadTime: pageLoadTime,
                         currentTime: Date.now(),
                         firebaseInitialized: typeof database !== 'undefined',
                         soundEnabled: soundEnabled,
                         customRingtone: customRingtone,
                         recentOrdersCount: recentOrders.length,
                         recentOrders: recentOrders
                     };
                 }
             };
         })();

</script>

@yield('scripts')

</body>
</html>
