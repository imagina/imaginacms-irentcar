@php
    $reservation = $data['extraParams']['reservation'];
@endphp

@extends($data["layout"] ?? setting('inotification::templateEmail'))

@section('content')

<div class="content-email-reservation">

    {{--
    <h1 class="title" style="text-align: center;width: 80%;font-size: 30px;margin: 12px auto;">
        {{itrans('irentcar::reservation.single')}} #{{$reservation->id}}
    </h1>
    --}}
    <div style="font-family:Trebuchet MS, Arial, sans-serif;font-size: 14px;line-height: 1.5; padding: 30px;">

        @include('irentcar::emails.reservation.partials.details')

        @include('irentcar::emails.reservation.partials.user-infor')

        @include('irentcar::emails.reservation.partials.gamma')

        @include('irentcar::emails.reservation.partials.payment')

        @include('irentcar::emails.reservation.partials.infor-extra')

    </div>

</div>

@stop