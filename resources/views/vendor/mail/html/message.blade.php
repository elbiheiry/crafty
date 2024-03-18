@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Salutation --}}
    @if (!empty($salutation))
        {{ $salutation }}
        {{ config('app.name') }}
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
        @isset($subcopy)
            @slot('subcopy')
                @lang(
                "إذا كنت تواجه مشكله في الضغط علي زر \":actionText\" , قم بنسخ ولصق هذا الرابط\n".
                'في المتصفح الخاص بكم:',
                [
                'actionText' => $actionText,
                ]
                ) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
            @endslot
        @endisset
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('جميع الحقوق محفوظه')
        @endcomponent
    @endslot
@endcomponent
