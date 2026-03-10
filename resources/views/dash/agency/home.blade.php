@extends('dashboard')

@section('content')
<div class="grid gap-6 grid-cols-2 py-5 pr-5">
    <!-- immobili -->
   @include("dash.agency.homePartials.properties")

    <!-- notifiche -->
    <?php if(count($notifications)) {?>
        @include("dash.agency.homePartials.notifications")
    <?php } ?>
@endsection
