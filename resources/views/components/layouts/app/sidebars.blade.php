<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">
<!-- Mirrored from keenthemes.com/metronic/tailwind/demo1/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Jul 2025 23:07:37 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>

    @include('partials.head')
    @include('partials.dash-head')


    <!-- Google tag (gtag.js) -->

</head>

<body class="antialiased flex h-full text-base text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = "light"; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem("kt-theme")) {
                themeMode = localStorage.getItem("kt-theme");
            } else if (
                document.documentElement.hasAttribute("data-kt-theme-mode")
            ) {
                themeMode =
                    document.documentElement.getAttribute("data-kt-theme-mode");
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ?
                    "dark" :
                    "light";
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        <!-- Sidebar -->
        <div class="kt-sidebar bg-background border-e border-e-border fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 [--kt-drawer-enable:true] lg:[--kt-drawer-enable:false]"
            data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
            <div class="kt-sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0"
                id="sidebar_header">
                <a class="dark:hidden" href="index.html">
                    <img class="default-logo min-h-[22px] max-w-none"
                        src="../../../static/metronic/tailwind/dist/assets/media/app/default-logo.svg" />
                    <img class="small-logo min-h-[22px] max-w-none"
                        src="../../../static/metronic/tailwind/dist/assets/media/app/mini-logo.svg" />
                </a>
                <a class="hidden dark:block" href="index.html">
                    <img class="default-logo min-h-[22px] max-w-none"
                        src="../../../static/metronic/tailwind/dist/assets/media/app/default-logo-dark.svg" />
                    <img class="small-logo min-h-[22px] max-w-none"
                        src="../../../static/metronic/tailwind/dist/assets/media/app/mini-logo.svg" />
                </a>
                <button
                    class="kt-btn kt-btn-outline kt-btn-icon size-[30px] absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
                    data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
                    <i
                        class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:kt-toggle-active:rotate-0">
                    </i>
                </button>
            </div>
            <div class="kt-sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
                <div class="kt-scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3"
                    data-kt-scrollable="true" data-kt-scrollable-dependencies="#sidebar_header"
                    data-kt-scrollable-height="auto" data-kt-scrollable-offset="0px"
                    data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
                    <!-- Sidebar Menu -->
                    <div class="kt-menu flex flex-col grow gap-1" data-kt-menu="true"
                        data-kt-menu-accordion-expand-all="false" id="sidebar_menu">
                        <div class="kt-menu-item here show">
                            <a href="{{ route('dashboard') }}" wire:navigate>
                                <div class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                    tabindex="0">
                                    <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                        <i class="ki-filled ki-element-11 text-lg"> </i>
                                    </span>
                                    <span
                                        class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                                        Dashboards
                                    </span>
                                </div>
                            </a>
                        </div>
                        @auth
                            @if (auth()->user()->hasRole(['super-admin', 'university-admin']))
                                <div class="kt-menu-item">
                                    <div class="kt-menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                        data-kt-menu-trigger="click" data-kt-menu-trigger-filter="true" tabindex="0">
                                        <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                                            <i class="ki-filled ki-setting-2 text-lg"> </i>
                                        </span>
                                        <span
                                            class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                                            Admin Management
                                        </span>
                                        <span class="kt-menu-arrow">
                                            <i class="ki-filled ki-right text-xs rtl:transform rtl:rotate-180">
                                            </i>
                                        </span>
                                    </div>
                                    <div class="kt-menu-sub kt-menu-default flex flex-col gap-1" data-kt-menu-dismiss="true">
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.users') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Users </span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.faculties') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Faculties </span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.departments') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Departments </span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.programmes') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Programmes </span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.academic-sessions') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Academic Sessions </span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.semesters') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Semesters </span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('admin.courses') }}" wire:navigate>
                                                <span class="kt-menu-bullet"> </span>
                                                <span class="kt-menu-title"> Courses </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <!-- End of Sidebar Menu -->
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->
        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            <!-- Header -->
            <header class="kt-header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-background"
                data-kt-sticky="true" data-kt-sticky-class="border-b border-border" data-kt-sticky-name="header"
                id="header">
                <!-- Container -->
                <div class="kt-container-fixed flex justify-between items-stretch lg:gap-4" id="headerContainer">
                    <!-- Mobile Logo -->
                    <div class="flex gap-2.5 lg:hidden items-center -ms-1">
                        <a class="shrink-0" href="index.html">
                            <img class="max-h-[25px] w-full"
                                src="../../../static/metronic/tailwind/dist/assets/media/app/mini-logo.svg" />
                        </a>
                        <div class="flex items-center">
                            <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-drawer-toggle="#sidebar">
                                <i class="ki-filled ki-menu"> </i>
                            </button>
                            <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-drawer-toggle="#mega_menu_wrapper">
                                <i class="ki-filled ki-burger-menu-2"> </i>
                            </button>
                        </div>
                    </div>
                    <!-- End of Mobile Logo -->
                    <!--Megamenu Contaoner-->

                    <!--End of Megamenu Contaoner-->
                    <!-- Topbar -->
                    <div class="flex ms-auto items-center gap-2.5">
                        <!-- Search -->
                        <button
                            class="group kt-btn kt-btn-ghost kt-btn-icon size-9 rounded-full hover:bg-primary/10 hover:[&amp;_i]:text-primary"
                            data-kt-modal-toggle="#search_modal">
                            <i class="ki-filled ki-magnifier text-lg group-hover:text-primary">
                            </i>
                        </button>
                        <!-- End of Search -->

                        <!--Notifications Drawer-->
                        
                        <!--End of Notifications Drawer-->
                        <!-- End of Notifications -->
                        <!-- Chat -->

                        <!-- User -->
                        <div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px"
                            data-kt-dropdown-offset-rtl="-20px, 10px" data-kt-dropdown-placement="bottom-end"
                            data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
                            <div class="cursor-pointer shrink-0" data-kt-dropdown-toggle="true">
                                <img alt="" class="size-9 rounded-full border-2 border-green-500 shrink-0"
                                    src="{{ asset('assets/media/avatars/300-2.png') }}" />
                            </div>
                            <div class="kt-dropdown-menu w-[250px]" data-kt-dropdown-menu="true">
                                <div class="flex items-center justify-between px-2.5 py-1.5 gap-1.5">
                                    <div class="flex items-center gap-2">
                                        <img alt="" class="size-9 shrink-0 rounded-full border-2 border-green-500"
                                            src="{{ asset('assets/media/avatars/300-2.png') }}" />
                                        <div class="flex flex-col gap-1.5">
                                            <span class="text-sm text-foreground font-semibold leading-none">
                                                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                                            </span>
                                            <a class="text-xs text-secondary-foreground hover:text-primary font-medium leading-none"
                                                href="account/home/get-started.html">
                                                {{ auth()->user()->email }}
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <ul class="kt-dropdown-menu-sub">
                                    <li>
                                        <div class="kt-dropdown-menu-separator"></div>
                                    </li>

                                    <li>
                                        <a class="kt-dropdown-menu-link" href="account/home/user-profile.html">
                                            <i class="ki-filled ki-profile-circle"> </i>
                                            My Profile
                                        </a>
                                    </li>



                                </ul>
                                <div class="px-2.5 pt-1.5 mb-2.5 flex flex-col gap-3.5">
                                    <div class="flex items-center gap-2 justify-between">
                                        <span class="flex items-center gap-2">
                                            <i class="ki-filled ki-moon text-base text-muted-foreground">
                                            </i>
                                            <span class="font-medium text-2sm"> Dark Mode </span>
                                        </span>
                                        <input class="kt-switch" data-kt-theme-switch-state="dark"
                                            data-kt-theme-switch-toggle="true" name="check" type="checkbox" value="1" />
                                    </div>
                                    <a class="kt-btn kt-btn-outline justify-center w-full"
                                        href="authentication/classic/sign-in.html">
                                        Log out
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End of User -->
                    </div>
                    <!-- End of Topbar -->
                </div>
                <!-- End of Container -->
            </header>
            <!-- End of Header -->
            <!-- Content -->
            <main class="grow pt-5" id="content" role="content">
                <!-- Container -->
                <div class="kt-container-fixed" id="contentContainer"></div>
                <!-- End of Container -->
                <!-- Container -->
                {{ $slot }}
                <!-- End of Container -->
            </main>
            <!-- End of Content -->
            <!-- Footer -->
            <footer class="kt-footer">
                <!-- Container -->
                <div class="kt-container-fixed">
                    <div class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-3 py-5">
                        <div class="flex order-2 md:order-1 gap-2 font-normal text-sm">
                            <span class="text-secondary-foreground"> 2025© </span>
                            <a class="text-secondary-foreground hover:text-primary" href="https://keenthemes.com/">
                                Keenthemes Inc.
                            </a>
                        </div>
                        <nav class="flex order-1 md:order-2 gap-4 font-normal text-sm text-secondary-foreground">
                            <a class="hover:text-primary" href="https://keenthemes.com/metronic/tailwind/docs">
                                Docs
                            </a>
                            <a class="hover:text-primary" href="https://1.envato.market/Vm7VRE">
                                Purchase
                            </a>
                            <a class="hover:text-primary"
                                href="https://keenthemes.com/metronic/tailwind/docs/getting-started/license">
                                FAQ
                            </a>
                            <a class="hover:text-primary" href="https://devs.keenthemes.com/">
                                Support
                            </a>
                            <a class="hover:text-primary"
                                href="https://keenthemes.com/metronic/tailwind/docs/getting-started/license">
                                License
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- End of Container -->
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->

    <!-- End of Share Profile Modal -->

    <!-- End of Page -->
    <!-- Scripts -->
    @include('partials.dash-scripts')
    <!-- End of Scripts -->
    @fluxScripts
</body>

<!-- Mirrored from keenthemes.com/metronic/tailwind/demo1/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Jul 2025 23:10:45 GMT -->

</html>