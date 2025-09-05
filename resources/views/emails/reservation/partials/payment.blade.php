<h3 style="font-size: 14px; margin-top: 20px; color: #000000;">
    {{itrans('irentcar::email.payment information')}}
</h3>

<p style="margin: 0; color: #000;">
    {{itrans('irentcar::email.basic price')}}
    <span style="color: #28a745;">${{ $reservation->gamma_office_price }} COP</span>
</p>

<p style="margin: 0; color: #555;">
    {{itrans('irentcar::email.tax price')}}
    ({{ $reservation->gamma_office_tax }}%)
    {{itrans('irentcar::email.tax price infor')}}
</p>

<h3 style="font-size: 14px; margin-top: 20px; color: #000000;">{{itrans('irentcar::email.total price')}}</h3>
<p style="margin: 0; font-weight: bold; color: #28a745;">
    ${{ $reservation->total_price}} COP</p>

<p style="margin: 0; color: #000;">{{itrans('irentcar::email.pay at dropoff')}}</p>
<p style="margin: 0; color: #000;"><strong>$ {{ $reservation->total_price_usd }} USD</strong>
    ({{ $reservation->total_price }} COP)</p>


<p style="margin: 10px 0; color: #555;">
    {{itrans('irentcar::email.usd and cop information')}}
</p>

<p style="margin: 10px 0; color: #000;">
    <strong>{{itrans('irentcar::email.gamma information')}}</strong>
</p>