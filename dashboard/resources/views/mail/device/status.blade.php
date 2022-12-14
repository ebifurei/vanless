<x-mail::message>
# Device Status Changed

Device : {{ $deviceName }}<br>
Message : {{ $body }}

<x-mail::button :url="$url" :color="$color">
See Device
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
