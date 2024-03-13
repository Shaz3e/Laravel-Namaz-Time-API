<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ config('app.name') }}</title>
    <!-- Favicon -->
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('dist/css/customize.css') }}">
</head>

<body class="hold-transition layout-fixed layout-navbar-fixed sidebar-mini @yield('body_class')">

    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <nav id="nav" class="fixed main-header navbar navbar-expand">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                @if (Auth::guard('admin')->user())
                @endif

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" role="button">
                        <i class="fa-solid fa-expand"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fa-solid fa-window-restore"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        {{-- Sidebar --}}
        @if (request()->is('admin') || request()->is('admin/*'))
            @include('layouts.admin-sidebar')
        @else
            @include('layouts.sidebar')
        @endif
        {{-- Sidebar --}}


        {{-- Content --}}
        @yield('content')
        {{-- Content --}}


        {{-- Footer --}}
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
        {{-- Footer --}}


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Theme Settings -->
    <script src="{{ asset('dist/js/theme-setting.js') }}"></script>
    <script>
        // Apply All Settings
        ApplyAllSettings();

        function ApplyAllSettings() {
            ShowThemeColor();
            // Mode
            ApplyDarkMode();
            // Sidebar Collapsed
            ApplySettings('Sidebar-Collapsed', "#sideBarCollapsedSettingsCheck", "body", 'sidebar-collapse');
            // Sidebar No Expand On Hover
            ApplySettings('Sidebar-No-Expand', "#sideBarNoExpandSettingsCheck", ".main-sidebar", 'sidebar-no-expand');
            // Nav Flat Style
            ApplySettings('Nav-Flat', "#navFlatSettingsCheck", ".nav-sidebar", 'nav-flat');
            // Nav Legacy Style
            ApplySettings('Nav-Legacy', "#navLegacySettingsCheck", ".nav-sidebar", 'nav-legacy');
            // Nav Compact Style
            ApplySettings('Nav-Compact', "#navCompactSettingsCheck", ".nav-sidebar", 'nav-compact');
            // Nav Indent Style
            ApplySettings('Nav-Child-Indent', "#navChildIndentSettingsCheck", ".nav-sidebar", 'nav-child-indent');
            // Nav Collapse Hide Child Style
            ApplySettings('Nav-Child-Hide-On-Collapse', "#navCollapseHideChildSettingsCheck", ".nav-sidebar",
                'nav-collapse-hide-child');
            // Footer Fixed Style
            ApplySettings('Sidebar-Footer-Fixed', "#sideBarFooterFixedSettingsCheck", "body", 'layout-footer-fixed');
            // Body Text Style
            ApplySettings('Body-Small-Text', "#bodyTextSettingsCheck", "body", 'text-sm');
        }



        // Save Settings
        function SaveSettings(settingName, settingValue) {
            localStorage.setItem(settingName, settingValue);
            // Apply All Settings
            ApplyAllSettings();
        }



        // Dark Mode
        function ApplyDarkMode() {

            // Get Setting
            let settingName = localStorage.getItem('Dark-Mode');

            // Elements
            let checkElement = $("#darkModeSettingsCheck"); // Checkbox
            let settingApplyElement = $("body"); // Body
            let settingApplyElement2 = $("#nav"); // Nav

            // Clear Settings
            settingApplyElement2.removeClass('navbar-white navbar-light navbar-dark'); // Nav

            // Apply Settings
            if (settingName == 0) {
                checkElement.removeAttr("checked"); // Remove Check
                settingApplyElement.removeClass('dark-mode'); // Body
                settingApplyElement2.addClass('navbar-white navbar-light'); // Nav
            } else if (settingName == 1) {
                checkElement.attr("checked", true); // Checked
                settingApplyElement.addClass('dark-mode'); // Body
                settingApplyElement2.addClass('navbar-dark'); // Nav
            } else if (settingName == null) {
                
                    checkElement.removeAttr("checked"); // Remove Check
                    settingApplyElement.removeClass('dark-mode'); // Body
                    settingApplyElement2.addClass('navbar-white navbar-light'); // Nav
                
            }
        }



        // Theme Color
        function ShowThemeColor() {

            let themeColor = localStorage.getItem('Theme-Color');
            let themeMode = localStorage.getItem('Dark-Mode');

            if (themeMode == null) {
                themeMode = "light";
            } else {
                if (themeMode == 1) {
                    themeMode = "dark";
                } else {
                    themeMode = "light";
                }
            }
            let themeColorSelect = $("#themeColorSettingsSelect");
            let sidebar = $(".main-sidebar");

          
            themeColorSelect.removeClass(
                'bg-white bg-danger bg-fuchsia bg-indigo bg-info bg-lightblue bg-lime bg-maroon bg-navy bg-orange bg-olive bg-pink bg-primary bg-purple bg-success bg-teal bg-warning'
            );
            $("#themeColorSettingsSelect option").each(function() {
                $(this).removeAttr("selected");
                if ($(this).val() == themeColor) {
                    $(this).attr("selected", true);
                    themeColorSelect.css({
                        "background": `var(--${themeColor})`,
                        "color": '#fff',
                    });
                }
            });

            sidebar.removeClass(
                'sidebar-dark-white sidebar-dark-danger sidebar-dark-fuchsia sidebar-dark-indigo sidebar-dark-info sidebar-dark-lightblue sidebar-dark-lime sidebar-dark-maroon sidebar-dark-navy sidebar-dark-orange sidebar-dark-olive sidebar-dark-pink sidebar-dark-primary sidebar-dark-purple sidebar-dark-success sidebar-dark-teal sidebar-dark-warning sidebar-light-white sidebar-light-danger sidebar-light-fuchsia sidebar-light-indigo sidebar-light-info sidebar-light-lightblue sidebar-light-lime sidebar-light-maroon sidebar-light-navy sidebar-light-orange sidebar-light-olive sidebar-light-pink sidebar-light-primary sidebar-light-purple sidebar-light-success sidebar-light-teal sidebar-light-warning'
            );
            sidebar.addClass(`sidebar-${themeMode}-${themeColor}`);

            $(":root").css("--themeColor", `var(--${themeColor})`);

            $(".text-theme").css({
                "color": `var(--${themeColor})`
            });

            $("button[type=submit], .btn-theme").css({
                "background": `var(--${themeColor})`,
                "border-color": `var(--${themeColor})`,
                "color": '#fff',
            });

            $(".text-theme").css({
                "color": `var(--${themeColor})`
            });

            $(".bg-theme").css({
                "background": `var(--${themeColor})`
            });

            $(".breadcrumb-item a").css({
                "color": `var(--${themeColor})`
            });

            $(".breadcrumb-item a").css({
                "color": `var(--${themeColor})`
            });


        }

        function ApplyThemeColor(themeColor) {
            if (themeColor != "") {
                localStorage.setItem('Theme-Color', themeColor);
            } else {
                localStorage.setItem('Theme-Color', "primary");
            }
            ShowThemeColor();
        }


        // Apply Nav Settings
        function ApplySettings(getSettingName, getCheckElement, getSettingApplyElement, getSettingApplyClass) {

            // Get Setting
            let settingName = localStorage.getItem(`${getSettingName}`);

            // Elements
            let checkElement = $(`${getCheckElement}`); // Checkbox
            let settingApplyElement = $(`${getSettingApplyElement}`); // Sidebar Nav

            // Apply Settings
            if (settingName == null || settingName == 0) {
                checkElement.removeAttr("checked"); // Remove Check
                settingApplyElement.removeClass(`${getSettingApplyClass}`); // Sidebar Nav
            } else {
                checkElement.attr("checked", true); // Checked
                settingApplyElement.addClass(`${getSettingApplyClass}`); // Sidebar Nav
            }
        }


        // Autocomplete Off
        $(document).ready(function() {
            $('input').attr('autocomplete', 'false');
        });
    </script>
    {{-- <script src="{{ asset('dist/js/customize.js') }}"></script> --}}
    {{-- Theme Setting --}}

    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

        <script>
            // do not auto format code
            toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right",
            "newestOnTop": true,
            "timeOut": "3000",
            "progressBar": true,
            }
        </script>
    @if (Session::has('message'))
        <script>
            toastr.success("{{ session('message')['text'] }}");
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error("{{ session('error')['text'] }}");
        </script>
    @endif
    @if (Session::has('license_error'))
        <script>
            toastr.error("{!! session('license_error')['text'] !!}");
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            toastr.info("{{ session('info')['text'] }}");
        </script>
    @endif
    @if (Session::has('warning'))
        <script>
            toastr.warning("{{ session('warning')['text'] }}");
        </script>
    @endif
    @yield('scripts')
</body>

</html>
