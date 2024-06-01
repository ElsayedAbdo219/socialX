<x-mail::message>
    # {{ $title }}

    @php
        $bodyLines = implode("\n", $body);
    @endphp

    {{ $bodyLines }}

</x-mail::message>
