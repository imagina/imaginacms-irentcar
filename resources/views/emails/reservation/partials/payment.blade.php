<h3 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">
    {{itrans('irentcar::email.payment information')}}
</h3>

<p style="margin: 0; color: #172E3F">
    {{itrans('irentcar::email.basic price')}}:
    <span style="font-weight:bold">${{ $reservation->gamma_office_price }} COP</span>
    {{--
    @if(!is_null($reservation->gamma_office_price_conversions))
    @foreach ($reservation->gamma_office_price_conversions as $key => $gopTotal)
    <span style="margin: 0; color: #000; text-transform:uppercase"><strong> | {{ $gopTotal }} {{$key}}
            (Aprox)</strong></span>
    @endforeach
    @endif
    --}}
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
        {{--
        @if(!is_null($reservation->gamma_office_extra_total_price_conversions))
        @foreach ($reservation->gamma_office_extra_total_price_conversions as $key => $extraTotal)
        <span style="margin: 0; color: #000; text-transform:uppercase"><strong> | {{ $extraTotal }} {{$key}}
                (Aprox)</strong></span>
        @endforeach
        @endif
        --}}
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

@if(!is_null($reservation->total_price_conversions))
    @foreach ($reservation->total_price_conversions as $key => $total)
        <p style="margin: 0; color: #000; text-transform:uppercase"><strong>{{ $total }} {{$key}}</strong>
            ({{ $reservation->total_price }} COP)</p>
    @endforeach
@endif

<hr style="color:#62748E4D">

<p style="margin: 10px 0; color: #5B6077; font-size: 12px;">
    {{itrans('irentcar::email.usd and cop information')}}
</p>

<hr style="color:#62748E4D">

<p style="margin: 10px 0; color: #5B6077;font-size:14px">
    <strong>{{itrans('irentcar::email.gamma information')}}</strong>
</p>

<hr style="color:#62748E4D">