<x-mail::message>
# Hi, {{ $mailData['name'] }}

Thank you registering with {{ config('app.name') }} below are your credentials.

<hr>

Email: **{{ $mailData['email'] }}**<br>
Password: **{{ $mailData['password'] }}**

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
