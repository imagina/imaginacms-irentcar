@php
    $user = $reservation->user;
    $fields = $user->fields;
@endphp

<h3 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">{{itrans('irentcar::email.user information')}}</h3>
<p style="margin: 0; color: #000;"><strong>{{itrans('irentcar::email.name')}}</strong>
</p>
<div style="font-size:14px; color: #5B6077; margin-bottom: 5px">
    {{ $user->first_name }}
    {{ $user->last_name }}
</div>
<p style="margin: 0; color: #000;"><strong>{{itrans('irentcar::email.email')}}</strong> </p>
<div style="font-size:14px; color: #5B6077; margin-bottom: 5px">
    {{ $user->email }}
</div>

<p style="margin: 0; color: #000;">{{itrans('iuser::users.fields.age')}}<strong>: </strong></p>
<div style="font-size:14px; color: #5B6077; margin-bottom: 5px">
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

<hr style="color:#62748E4D">