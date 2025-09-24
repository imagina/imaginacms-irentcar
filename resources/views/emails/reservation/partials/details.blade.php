<div>
  <h2 style="font-size: 26px; margin-bottom: 10px; color: #212529;font-weight:800;">
    {{itrans('irentcar::email.reservation details')}}
  </h2>
  <br>
  <p style="margin: 0; color: #212529; font-size:22px">
    <strong>{{itrans('irentcar::email.confirmation number')}}:</strong>
  </p>
  <div style="font-size:22px; color: #212529;font-weight: 800;">
    <em>{{ $reservation->id}}</em>
  </div>
  
  {{--ONLY CREATED--}}
  @if($reservation->status_id == "1")
    <p style="font-size:14px; margin: 10px 0; color: #555;">
      {{itrans('irentcar::email.confirmation description')}}
    </p>
  @else
    {{--ONLY UPDATED--}}
    <p style="font-size:14px; margin: 10px 0; color: #555;">
      <strong>{{itrans('irentcar::email.status')}}:</strong>
    </p>
    <div style="font-size:14px; color: #212529;text-transform:uppercase">
      <strong>{{$reservation->status['title']}}</strong>
    </div>
  @endif
  
  <hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">
  
  {{--DETAILS RESERVATION--}}
  <h2 style="font-size: 22px; margin-bottom: 25px; color: #212529;">
    {{itrans('irentcar::email.reservation details')}}
  </h2>
  
  <h3 style="font-size: 16px; margin: 0; color: #212529;">
    {{itrans('irentcar::email.pickup date')}}
  </h3>
  <div style="margin-bottom: 5px; color: #555; font-size: 14px;">
    {{ $reservation->pickup_date->translatedFormat('l, d/m/Y - H:i') }}
  </div>
  
  <h3 style="font-size: 16px; margin: 15px 0 0; color: #212529;">{{itrans('irentcar::email.dropoff date')}}</h3>
  <div style="margin-bottom: 5px; color: #555; font-size: 14px;">
    {{ $reservation->dropoff_date->translatedFormat('l, d/m/Y - H:i') }}
  </div>
  
  <h3 style="font-size: 16px; margin: 15px 0 0; color: #212529;">{{itrans('irentcar::email.pickup office')}}</h3>
  <div style="margin-bottom: 5px; color: #555; font-size: 14px;">{{ $reservation->pickupOffice->title }}</div>
  
  <h3 style="font-size: 16px; margin: 15px 0 0; color: #212529;">{{itrans('irentcar::email.dropoff office')}}</h3>
  <div style="margin-bottom: 5px; color: #555; font-size: 14px;">{{ $reservation->dropoffOffice->title }}</div>
  
  @if(!empty($reservation->options["flyNumber"]))
    <h3 style="font-size: 16px; margin: 0; color: #212529;">
      {{itrans('irentcar::email.number flight')}}
    </h3>
    <div style="margin-bottom: 5px; color: #555; font-size: 14px;">
      {{ $reservation->options["flyNumber"] }}
    </div>
  @endif
  
  <hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">
</div>