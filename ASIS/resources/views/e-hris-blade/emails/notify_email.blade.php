@component('mail::message')
# Good Day, Greetings from DSSC!
{{--<div class="w-10 h-10 rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5"><img alt="logo" src=" {{ GLOBAL_EMAIL_HEADER() }}"></div>--}}

@if (system_settings())
@php
$system_title = system_settings()->where('key','system_title')->first();
@endphp

@if ($system_title)
<span class="text-black text-lg ml-3"> {{ $system_title->value }}</span>
@else
<span class="text-black text-lg ml-3"> N/A </span>
@endif
@else
<img alt="logo" class="w-10" src="">
<span class="text-black text-lg ml-3"> N/A </span>
@endif

{{ $content }}

{{--@component('mail::button', ['url' => $url])--}}
{{--Click to redirect in Student Portal--}}
{{--@endcomponent--}}

{{ $closing }}<br>

<div class="w-10 h-10 rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5"><img alt="logo" src=" {{ $image }}"></div>
@endcomponent
