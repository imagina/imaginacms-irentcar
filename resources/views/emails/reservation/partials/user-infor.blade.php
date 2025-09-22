@php
  $user = $reservation->user;
  $fields = $user->fields;
@endphp
<div>
  <h2 style="font-size: 22px; margin-bottom: 25px; color: #212529;">
    {{itrans('irentcar::email.user information')}}
  </h2>
  
  <p style="margin:15px 0 0; color: #212529;font-size: 17px;"><strong>{{itrans('irentcar::email.name')}}</strong>
  </p>
  <div style="font-size:14px; color: #555; margin-bottom: 5px">
    {{ $user->first_name }}
    {{ $user->last_name }}
  </div>
  <p style="margin:15px 0 0; color: #212529;font-size: 17px;">
    <strong>{{itrans('irentcar::email.email')}}</strong>
  </p>
  <div style="font-size:14px; color: #555; margin-bottom: 5px">
    {{ $user->email }}
  </div>
  
  <p style="margin:15px 0 0; color: #212529;font-size: 17px;">
    <strong>{{itrans('iuser::users.fields.age')}}: </strong>
  </p>
  <div style="font-size:14px; color: #555; margin-bottom: 5px">
    {{$user->age}}
  </div>
  
  {{--
  @foreach ($fields as $field)
  <p style="margin: 0; color: #000;"><strong>{{$field->title}}: </strong></p>
  <div style="font-size:14px; color: #5B6077; margin-bottom: 5px">
      {{$field->value}}
  </div>
  @endforeach
  --}}
  
  <hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">

</div>