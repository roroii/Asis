@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('My Signature') }}
@endsection

@section('content')


<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        My Signature
    </h2>
    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn-primary shadow-md mr-2">Add New Product</button>
        <div class="dropdown ml-auto sm:ml-0">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="file-plus" class="w-4 h-4 mr-2"></i> New Category </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> New Group </a>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}
</div>



<div class="intro-y box p-5 mt-5">
    <form id="save_user_signature" enctype="multipart/form-data">
        @csrf
        <div>
           <input type="file" name="user_signature" id="user_signature">
        </div>
        <div class="intro-y items-center text-center box p-5 mt-5">
            <button type="submit" class="btn btn-primary w-32 mr-2 mb-2">
                <i class="fas fa-save w-4 h-4 mr-2"></i> Save
            </button>
        </div>
    </form>
</div>



@endsection

@section('scripts')
    <script src="{{ asset('/js/signature/signature.js') }}"></script>

@endsection
