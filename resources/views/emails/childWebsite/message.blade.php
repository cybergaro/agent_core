@extends('emails.template')
@section('content')

@php
    $categoryTranslations = [
        'buy'          => 'Cerco un immobile da acquistare',
        'sell'         => 'Vorrei vendere il mio immobile',
        'evaluation'   => 'Richiesta valutazione gratuita',
        'visit_buy'    => 'Visita per annuncio di vendita',
        'rent'         => 'Cerco un immobile in affitto',
        'let'          => 'Propongo il mio immobile per l\'affitto',
        'visit_rent'   => 'Visita per annuncio di affitto',
        'management'   => 'Gestione affitti / Property Management',
        'mortgage'     => 'Informazioni su mutui e finanziamenti',
        'technical'    => 'Informazioni tecniche o burocratiche',
        'construction' => 'Cantieri e nuove costruzioni',
        'job'          => 'Lavora con noi / Candidatura',
        'other'        => 'Informazioni generali / Altra richiesta'
    ];
@endphp

<h1 style="color: #333333;">Nuovo messaggio dal sito web</h1>

<p style="color: #555555;">
    <b>Nome:</b> <?= $name ?> <br>
    <b>Telefono:</b> <?= $tel ?> <br>
    <b>Email:</b> <?= $email ?> <br>
    <b>Categoria:</b> <?= $categoryTranslations[$category] ?> <br>
    <b>Message:</b> <?= $message ?> <br>
</p>

<p style="color: #555555;">
    Puoi visualizzare questo messaggio anche all'interno della dashboard della tua agenzia su Agent Core o, se lo hai configurato, anche da Google Sheet. 
</p>

@endsection