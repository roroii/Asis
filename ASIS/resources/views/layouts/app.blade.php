<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    @include('_partials.head')
</head>
<!-- END: Head -->
<body class="py-5">



    <!-- BEGIN: Mobile Menu -->
    @include('_partials.mobile')
    <!-- END: Mobile Menu -->


    <div class="flex mt-[4.7rem] md:mt-0">
        <!-- BEGIN: Side Menu -->
    @include('_partials.sidebar')
    <!-- END: Side Menu -->


    <!-- BEGIN: Content -->
    <div class="content">
    <!-- BEGIN: Top Bar -->
    @include('_partials.topbar')
    <!-- END: Top Bar -->


        @yield('content')

    </div>
    <!-- END: Content -->
    <div id="loader-wrapper" class="loader-wrapper">
        <span class="loader">
            <div class=" col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                <i data-loading-icon="oval" class="w-100 w-100" ></i>
            </div>
        </span>
    </div>

    <section id="loading">
        <div id="loading-content"></div>
      </section>
    <!--<div id="__notif_content_src" style="display: none;"></div>-->


</div>
<!-- BEGIN: Dark Mode Switcher-->
{{--<div data-url="side-menu-dark-dashboard-overview-1.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">--}}
{{--    <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>--}}
{{--    <div class="dark-mode-switcher__toggle border"></div>--}}
{{--</div>--}}
<!-- END: Dark Mode Switcher-->

<!-- BEGIN: JS Assets-->

@include('_partials.scripts')



@yield('scripts')



<script>
    var __basepath = "{{url('')}}";
    var timeout = null;

    $(window).on("load",function(){


    $(".loader-wrapper").fadeOut("slow");

    });

function showLoading() {
  document.querySelector('#loading').classList.add('loading');
  document.querySelector('#loading-content').classList.add('loading-content');
}

function hideLoading() {
  document.querySelector('#loading').classList.remove('loading');
  document.querySelector('#loading-content').classList.remove('loading-content');
}

</script>
{{--<script src="{{ asset('/js/open_notification.js') }}"></script>--}}
<script src="{{ asset('/js/dropdown.js') }}"></script>
<script src="{{ asset('/js/logout.js') }}"></script>

<!-- END: JS Assets-->
</body>
</html>
