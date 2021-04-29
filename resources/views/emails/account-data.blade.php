@component('mail::message')
# Hello {{ $model->name }}
<h1>{{ $subject }}</h1>
<p> {!! $announcement !!}</p>
@component('mail::button', ['url' => '/'])
Login to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
