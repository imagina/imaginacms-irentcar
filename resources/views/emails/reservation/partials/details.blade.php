<h2 style="font-size: 25px; margin-bottom: 10px; color: #0000000;">{{itrans('irentcar::email.reservation details')}}
</h2>

<p style="margin: 0; color: #000;"><strong>{{itrans('irentcar::email.confirmation number')}}:</strong>
    {{ $reservation->id}}
</p>
<p style="margin: 10px 0; color: #555;">
    {{itrans('irentcar::email.confirmation description')}}
</p>

<hr>

<h2 style="font-size: 14px; margin-bottom: 10px; color: #0000000;">{{itrans('irentcar::email.reservation details')}}
</h2>

<h3 style="font-size: 14px; margin-top: 20px; color: #0000000;">{{itrans('irentcar::email.pickup date')}}</h3>
<p style="margin: 0; color: #000;">{{ $reservation->pickup_date->translatedFormat('l, d/m/Y - H:i') }}</p>

<h3 style="font-size: 14px; margin-top: 10px; color: #0000000;">{{itrans('irentcar::email.dropoff date')}}</h3>
<p style="margin: 0; color: #000;">{{ $reservation->dropoff_date->translatedFormat('l, d/m/Y - H:i') }}</p>

<h3 style="font-size: 14px; margin-top: 10px; color: #0000000;">{{itrans('irentcar::email.pickup office')}}</h3>
<p style="margin: 0; color: #000;">{{ $reservation->pickupOffice->title }}</p>

<h3 style="font-size: 14px; margin-top: 10px; color: #0000000;">{{itrans('irentcar::email.dropoff office')}}</h3>
<p style="margin: 0; color: #000;">{{ $reservation->dropoffOffice->title }}</p>

<hr>