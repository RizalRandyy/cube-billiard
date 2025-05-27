@component('mail::message')

# Reset Password Anda

Kami menerima permintaan untuk mereset password.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Jika Anda tidak meminta reset password, abaikan saja email ini.

Salam hangat,  
Cube Billiard
@endcomponent
