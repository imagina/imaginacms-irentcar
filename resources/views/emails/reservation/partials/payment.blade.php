<h3 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">
    {{itrans('irentcar::email.payment information')}}
</h3>

<p style="margin: 0; color: #172E3F">
    {{itrans('irentcar::email.basic price')}}:
    <span style="font-weight:bold">${{ $reservation->gamma_office_price }} COP</span>
</p>

<p style="margin: 0; color: #555;">
    {{itrans('irentcar::email.tax price')}}
    ({{ $reservation->gamma_office_tax }}%)
    {{itrans('irentcar::email.tax price infor')}}
</p>

@if($reservation->gamma_office_extra_total_price > 0)
    <p style="margin: 0; margin-top:7px; color: #172E3F">
        {{itrans('irentcar::email.extras total price')}}:
        <span style="font-weight:bold">${{ $reservation->gamma_office_extra_total_price }} COP</span>
    </p>
@endif

<p style="margin: 0; margin-top:7px; color: #172E3F">
    {{itrans('irentcar::email.rental days')}}:
    <span style="font-weight:bold">{{ $reservation->rental_days }}</span>
</p>

<hr style="color:#62748E4D">

<h3 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">
    {{itrans('irentcar::email.total price')}}: ${{ $reservation->total_price}} COP
</h3>

<p style="margin-bottom: 0px; color: #172E3F">{{itrans('irentcar::email.pay at dropoff')}}</p>
<p style="margin: 0; color: #000;"><strong>$ {{ $reservation->total_price_usd }} USD</strong>
    ({{ $reservation->total_price }} COP)</p>

<hr style="color:#62748E4D">

<p style="margin: 10px 0; color: #5B6077; font-size: 12px;">
    {{itrans('irentcar::email.usd and cop information')}}
</p>

<hr style="color:#62748E4D">

<p style="margin: 10px 0; color: #5B6077;font-size:14px">
    <strong>{{itrans('irentcar::email.gamma information')}}</strong>
</p>

<hr style="color:#62748E4D">