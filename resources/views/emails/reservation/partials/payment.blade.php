<div>
  <h2 style="font-size: 22px; margin-bottom: 25px; color: #212529;">
    {{itrans('irentcar::email.payment information')}}
  </h2>
  
  <p style="margin-bottom: 5px; color: #555; font-size: 14px;">
    {{itrans('irentcar::email.basic price')}}:
    <strong><em>${{ $reservation->gamma_office_price }} COP</em></strong>
    {{--
    @if(!is_null($reservation->gamma_office_price_conversions))
    @foreach ($reservation->gamma_office_price_conversions as $key => $gopTotal)
    <span style="margin: 0; color: #000; text-transform:uppercase"><strong> | {{ $gopTotal }} {{$key}}
            (Aprox)</strong></span>
    @endforeach
    @endif
    --}}
  </p>
  
  <p style="margin-bottom: 5px; color: #555; font-size: 14px;">
    {{itrans('irentcar::email.tax price')}}
    ({{ $reservation->gamma_office_tax }}%)
    {{itrans('irentcar::email.tax price infor')}}
  </p>
  
  @if($reservation->gamma_office_extra_total_price > 0)
    <p style="margin-bottom: 5px; color: #555; font-size: 14px;">
      {{itrans('irentcar::email.extras total price')}}:
      <strong><em>${{ $reservation->gamma_office_extra_total_price }} COP</em></strong>
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
  
  <p style="margin-bottom: 5px; color: #555; font-size: 14px;">
    {{itrans('irentcar::email.rental days')}}:
    <span style="font-weight:bold">{{ $reservation->rental_days }}</span>
  </p>
  
  <hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">

  
  <h3 style="margin-bottom: 5px; color: #212529; font-size: 15px;">
    {{itrans('irentcar::email.total price')}}:
    <em style="font-weight: 900;font-size: 22px;">{{ $reservation->total_price}} COP</em>
  </h3>
  
  <p style="margin-bottom: 5px; color: #555; font-size: 14px;">{{itrans('irentcar::email.pay at dropoff')}}:</p>
  
  @if(!is_null($reservation->total_price_conversions))
    @foreach ($reservation->total_price_conversions as $key => $total)
      <p style="margin-bottom: 5px; color: #212529; font-size: 16px;text-transform: uppercase;">
        <strong><em>{{ $total }} {{$key}}</em></strong>
        ({{ $reservation->total_price }} COP)</p>
    @endforeach
  @endif
  
  <p style="margin: 30px 0 0; color: #777777; font-size: 12px; text-align: center;">
    {{itrans('irentcar::email.usd and cop information')}}
  </p>
  
  <hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">

  <h2 style="font-size: 22px; margin-bottom: 15px; color: #212529;">
    {{trans('irentcar::email.extra information gamma')}}
  </h2>
  <p style="font-size:14px; margin: 10px 0; color: #555;">
    <strong>{{itrans('irentcar::email.gamma information')}}</strong>
  </p>
</div>