@extends('emails.template')
@section('content')

<h1 style="color: #333333;">Nuovo messaggio dal sito web</h1>

<p style="color: #555555;">
    <b>Nome:</b> <?= $name ?> <br>
    <b>Telefono:</b> <?= $tel ?> <br>
    <b>Email:</b> <?= $email ?> <br>
    <b>Message:</b> <?= $message ?> <br>
</p>

<p style="color: #555555;">
    Puoi visualizzare questo messaggio anche all'interno della dashboard della tua agenzia su Agent Core o, se lo hai configurato, anche da Google Sheet. 
</p>

@endsection