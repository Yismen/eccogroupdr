@component('mail::message')

# Hello

Please note user {{ $user->name }}, with email address {{ $user->email }}, has {{ str($title)->after(" ")->lower()
}} in your app {{ config('app.name') }}

@component('mail::button', [
'url' => route('users.index')
])
View Users

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent