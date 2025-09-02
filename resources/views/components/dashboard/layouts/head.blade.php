<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="true">
  <meta name="keywords" content="true">
  <meta name="author" content="true">
  <meta name="_token" content="{{ csrf_token() }}">

  <!-- favicon -->
  <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>


  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">



  <title>@yield('title')</title>
  <link rel="apple-touch-icon" href="{{ asset('dashboardAssets/app-assets/images/logo/logo.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboardAssets/app-assets/images/logo/logo.png') }}">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/vendors-rtl.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/charts/apexcharts.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/extensions/tether-theme-arrows.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/extensions/tether.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/extensions/shepherd-theme-default.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/extensions/swiper.min.css') }}">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/app-assets/css-rtl/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/bootstrap-extended.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/dashboardAssets/app-assets/css-rtl/colors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/app-assets/css-rtl/components.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/themes/dark-layout.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/themes/semi-dark-layout.css') }}">

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/pages/dashboard-analytics.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/pages/card-analytics.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/app-assets/css-rtl/plugins/tour/tour.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/app-assets/css-rtl/pages/app-user.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css-rtl/pages/app-ecommerce-details.css') }}">


  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/app-assets/css-rtl/custom-rtl.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/assets/css/style-rtl.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboardAssets/app-assets/css/iziToast.min.css') }}">
  <!-- END: Custom CSS-->
  <!-- BEGIN: SELECT2 CSS-->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
  <!-- END: SELECT2 CSS-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('dashboardAssets/app-assets/css/pickers/pickadate/pickadate.css') }}">


  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  {{-- dubai font --}}
  <link href="https://fonts.googleapis.com/css2?family=Dubai:wght@400;500;700&display=swap" rel="stylesheet">


  <!-- all css -->
  <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
  <!-- slick css -->
  <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
  <!-- metisMenu css -->
  <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
  <!-- style css -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- lineProgressbar css -->
  <link rel="stylesheet" href="{{ asset('assets/css/jquery.lineProgressbar.css') }}">
  <!-- responsive fonts -->
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">




  @yield('styles')


  <style>
    body {
      font-family: 'Dubai', sans-serif;
    }

    .menu-content {
      background: none;

    }

    .main-menu.menu-light .navigation>li ul li {
      background: none;
    }

    .card_stats {
      border: 1px solid #ddd;
      margin-right: 60px;
      margin-top: 60px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      background-color: white;
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .card-statistic {
      margin-bottom: 20px;
    }

    .card-statistic h6 {
      font-size: 0.875rem;
      color: #666;
    }

    .card-statistic p {
      font-size: 1.25rem;
      font-weight: bold;
      color: #333;
    }

    .language-dropdown {
      position: relative;
      display: inline-block;
    }

    .language-dropdown select {
      background-color: #fff;
      border: 2px solid blue;
      padding: 10px 14px;
      font-size: 15px;
      border-radius: 8px;
      cursor: pointer;
      color: #222;
      font-weight: bold;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 140 140' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M35 50l35 35 35-35' fill='none' stroke='%23000' stroke-width='15'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px;
      padding-right: 35px;
      box-shadow: blue;
      transition: all 0.3s ease;
    }

    /* .language-dropdown select:hover {
    border-color: #2ecc71;
    box-shadow: 0 0 12px rgba(0, 255, 0, 0.5);
} */

    /* تنبيه: بعض المتصفحات تتجاهل هذا الجزء */
    .language-dropdown option {
      background-color: #f0fff0;
      color: #222;
      font-weight: bold;
    }
  </style>
</head>