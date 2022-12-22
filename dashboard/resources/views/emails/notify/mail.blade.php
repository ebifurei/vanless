<x-mail::message>
# Notify Mail

Device : {{ $device_name }}<br>
Message : {{ $message }}<br>

<x-mail::button :url="$link">
    See Device
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
