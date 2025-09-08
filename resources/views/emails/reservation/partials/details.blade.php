<h2 style="font-size: 25px; margin-bottom: 10px; color: #172E3F;">{{itrans('irentcar::email.reservation details')}}
</h2>
<br>
<p style="margin: 0; color: #000; font-size:14px">
    <strong>{{itrans('irentcar::email.confirmation number')}}:</strong>
</p>
<div style="font-size:22px; color: #172E3F">
    {{ $reservation->id}}
</div>

<p style="font-size:14px; margin: 10px 0; color: #172E3F;">
    {{itrans('irentcar::email.confirmation description')}}
</p>

<hr style="color:#62748E4D">

<h2 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">{{itrans('irentcar::email.reservation details')}}
</h2>

<h3 style="font-size: 14px; margin: 0px; color: #0000000;">{{itrans('irentcar::email.pickup date')}}</h3>
<div style="margin-bottom: 5px; color: #5B6077; font-size: 14px;">
    {{ $reservation->pickup_date->translatedFormat('l, d/m/Y - H:i') }}
</div>

<h3 style="font-size: 14px; margin:0px; color: #0000000;">{{itrans('irentcar::email.dropoff date')}}</h3>
<div style="margin-bottom: 5px; color: #5B6077; font-size: 14px;">
    {{ $reservation->dropoff_date->translatedFormat('l, d/m/Y - H:i') }}
</div>

<h3 style="font-size: 14px; margin:0px; color: #0000000;">{{itrans('irentcar::email.pickup office')}}</h3>
<div style="margin-bottom: 5px; color: #5B6077; font-size: 14px;">{{ $reservation->pickupOffice->title }}</div>

<h3 style="font-size: 14px; margin:0px; color: #0000000;">{{itrans('irentcar::email.dropoff office')}}</h3>
<div style="margin-bottom: 5px; color: #5B6077; font-size: 14px;">{{ $reservation->dropoffOffice->title }}</div>

<hr style="color:#62748E4D">