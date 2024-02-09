<meta charset="UTF-8">


@if (system_settings())
@php
    $system_title = system_settings()->where('key','agency_name')->first();
    $system_logo = system_settings()->where('key','agency_logo')->first();
@endphp

@if ($system_logo)

<link style="border-radius: 50%" href="{{ asset('uploads/settings/'.$system_logo->image.'') }}" class=" rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5" rel="shortcut icon">

@else
<link href="" rel="shortcut icon">
@endif

@if ($system_title)
    <title>{{ $system_title->value }}</title>
@else
<title>{{ $system_title->value }}</title>
@endif

@else
<link href="" rel="shortcut icon">
<title>N/A</title>
@endif




@if (system_settings()->where('key','system_title')->first())
@php
    $system_setting = system_settings()->where('key','system_title')->first();
@endphp

@if ($system_setting->value)
    <title>{{ $system_setting->value }}</title>
@else
    <title>N/A</title>
@endif

@else
<title>N/A</title>
@endif


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="e-HRIS">
<meta name="keywords" content="e-HRIS">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
@auth
<meta name="current-user-id" content="{{ current_user_id() }}">
@endauth
<meta name="basepath" content="{{BASEPATH()}}">



<!-- Font Awesome 6.2.1 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Font Awesome 6.2.1 Thin CSS -->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/thin.min.css" integrity="sha512-G/T7HQJXSeNV7mKMXeJKlYNJ0jrs8RsWzYG7rVACye+qrcUhEAYKYzaa+VFy6eFzM2+/JT1Q+eqBbZFSHmJQew==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<link rel="stylesheet" href="{{url('')}}/vendor/icofont/icofont.min.css">




<!-- BEGIN: CSS Assets-->
<link rel="stylesheet" href="{{url('')}}/assets/datatable/datatables_1.13.1/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="{{url('')}}/dist/css/app.css" />

<link rel="stylesheet" href="{{url('')}}/assets/fa.5.15.4/css/all.min.css" />
<link rel="stylesheet" href="{{url('')}}/assets/uniupload/uniupload.css{{GET_RES_TIMESTAMP()}}" />
<!-- END: CSS Assets-->


<link href="{{url('')}}/assets/filepond-master/dist/filepond.css" rel="stylesheet">
<link href="{{url('')}}/assets/filepond-master/dist/filepond.min.css" rel="stylesheet">
<link href="{{url('')}}/assets/filepond-master/dist/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" rel="stylesheet">


{{-- selec2 cdn --}}
<link href="{{BASEPATH()}}/vendor/select2/css/select2.min.css{{GET_RES_TIMESTAMP()}}" rel="stylesheet" />
<link href="{{BASEPATH()}}/vendor/select2/css/select2.single-error.css{{GET_RES_TIMESTAMP()}}" rel="stylesheet" />
<link href="{{BASEPATH()}}/vendor/select2/css/select2.multiple-error.css{{GET_RES_TIMESTAMP()}}" rel="stylesheet" />
<link href="{{BASEPATH()}}/vendor/select2/css/select2.custom.css{{GET_RES_TIMESTAMP()}}" rel="stylesheet" />



<!-- plugin css file  -->
<link rel="stylesheet" href="{{url('')}}/assets/plugin/datatables/responsive.dataTables.min.css">
<link rel="stylesheet" href="{{url('')}}/assets/plugin/datatables/dataTables.bootstrap5.min.css">
<link href="{{url('')}}/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>


<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{url('')}}/vendor/tooltipster/css/tooltipster.bundle.css{{GET_RES_TIMESTAMP()}}" />

<link rel="stylesheet" href="{{url('')}}/css/custom.css{{GET_RES_TIMESTAMP()}}" />
<link rel="stylesheet" href="{{url('')}}/assets/mycalendar/style.css{{GET_RES_TIMESTAMP()}}" />

<!-- chart plugs  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<!-- Add this link in the head section of your layout -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

<!--Material datatable design-->
<link rel="stylesheet" href="{{url('')}}/css/datatable_custom.css{{GET_RES_TIMESTAMP()}}">


{{-- <script src="{{url('')}}/dist/js/vanilla/zoom-vanilla.js{{GET_RES_TIMESTAMP()}}"></script> --}}

<script async src="https://www.google.com/recaptcha/api.js"></script>


  <!-- Include Dropzone.js -->
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script> --}}