@extends('emails.template')
@section('content')

<h1 style="color: #333333;">Nuova richiesta di valutazione ricevuta</h1>

<p style="color: #555555;">
    <b>Nome:</b> <?= $name ?> <br>
    <b>Telefono:</b> <?= $tel ?> <br>
    <b>Email:</b> <?= $email ?> <br>
    <b>Numero locali:</b> <?= $n_room ?> <br>
    <b>Metri quadri:</b> <?= $size ?> <br>
    <b>Indirizzo:</b> <?= $address ?> <br>
    <b>Descrizione:</b> <?= $description ?> <br>
</p>

<p style="color: #555555;">
    Puoi visualizzare questo messaggio anche all'interno della dashboard della tua agenzia su Agent Core
</p>

@endsection