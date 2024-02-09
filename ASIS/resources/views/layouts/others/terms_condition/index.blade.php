@extends('layouts.app')

@section('content')
<style>

    p {
      color: black;
      margin-top: 1em;
      margin-bottom: 1px;
      /* text-transform: uppercase; */
      /* text-indent: 20px; */
    }

    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
    #div_of_term_condition{
        padding: 25px;
    }

    ul {
        color: black;
        display: block;
        list-style-type: disc;
        margin-top: 1em;
        margin-bottom: 1px;
        margin-left: 0;
        margin-right: 0;
        padding-left: 40px;
        }
    li {
        display: list-item;
        }
    </style>

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Terms, Condition and Policy
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @if (Auth::user()->role_name == 'Admin')
                <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#update_content_term_condition">Update Contents</button>
            @else
                <button class="btn btn-primary shadow-md mr-2">Print</button>
            @endif
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Content -->
    <div id="div_of_term_condition" class="intro-y box overflow-hidden mt-5 p-4 editor">
        {!! html_entity_decode(get_term_condition()->desc_content) !!}
    </div>
    <!-- END: Content -->

    @if (Auth::user()->role_name == 'Admin')

        @include('others.terms_condition.modal.term_condition_content_modal')

    @else

    @endif

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script src="{{ asset('/js/others/term_condition.js') }}"></script>
{{-- <script src="../dist/js/ckeditor-classic.js"></script> --}}
@endsection

