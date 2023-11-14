
@section('subject')
{{ config('app.name') }} - Password Reset
@endsection

@section('content')
<p>You have requested to reset your password for your {{ config('app.name') }} account.</p>

<p>To reset your password, please click on the following link:</p>

<p><a href="{{ $url }}">{{ $url }}</a></p>

<p>This link will expire in {{ config('auth.passwords.expire') }} minutes.</p>

@if (config('auth.passwords.hint'))
<p>If you did not request to reset your password, you can safely ignore this email.</p>
@endif
