@extends('emails.template')
@section('content')

<h1 style="color: #333333;">Verifica la tua email</h1>

<p style="color: #555555;">
    Benvenuto su Agent Core! Verifica la tua mail per continuare ad utilizzare il tuo account.
</p>

<a 
    href="<?= env("APP_URL") ?>/emailCheck/<?= $token ?>"
    style="display: inline-block; background-color: #f15828; color:white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; font-size:17px"
>
    Verifica la tua email
</a>  

@endsection