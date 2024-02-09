@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

    @if (Auth::check())
        @if ($enrollmentSettings['notificationHeader'])
            <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
                <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
                <span>{{ $enrollmentSettings['notificationHeader'] }} </span>
                <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
            </div>
        @endif
    @elseif(auth()->guard('enrollees_guard')->check())
        <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span> WELCOME FUTURE STUDENTS OF DAVAO DEL SUR STATE COLLEGE!! </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>
    @elseif(auth()->guard('employee_guard')->check())
        <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span> ADMIN!! </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>
    @endif
@endsection

@section('scripts')

    @if(Auth::check())
        <script src="{{ asset('/js/publicFiles.js') }}"></script>
        <script src="{{ asset('/js/document_swal.js') }}"></script>
        <script src="{{ asset('/js/scan_Doc.js') }}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        {{-- <script src="{{ asset('/js/global_js.js') }}"></script> --}}
    @else
    @endif
@endsection
