@component('mail::message')
# Good Day, Greetings from DSSC!
{{--<div class="w-10 h-10 rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5"><img alt="logo" src=" {{ GLOBAL_EMAIL_HEADER() }}"></div>--}}

@if (system_settings())
@php
$system_title = system_settings()->where('key','system_title')->first();
@endphp
@endif

{{ $content }}

@component('mail::button', ['url' => $url])
Verify Email Address
@endcomponent

{{ $closing }}<br>
<br>
{{ $closing_2 }}<br>

# {{  $system_title->value }}

{{--<div class="w-10 h-10 rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5"><img alt="logo" src=" {{ $image }}"></div>--}}
@endcomponent
