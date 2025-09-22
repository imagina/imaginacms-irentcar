@php
  use Modules\Irentcar\Transformers\GammaTransformer;

  //Get Gamma
  $gamma = $reservation->gamma;
  //Check Relation Files
  $gamma->loadMissing('files');
  //Transform Data to include relation Files with data
  $gammaTransformed = (new GammaTransformer($gamma))->toArray(request());
  $filesByZone = $gammaTransformed['files'] ?? [];

@endphp
<h2 style="font-size: 22px; margin-bottom: 25px; color: #212529;">
  {{itrans('irentcar::email.car information')}}
</h2>

<table style="width: 100%; border-collapse: collapse;" role="presentation" width="100%" cellspacing="0" cellpadding="0"
       border="0">
  <tr>
    <td width="50%">
      @if(!empty($filesByZone) && isset($filesByZone->mainimage))
        <img src="{{ $filesByZone->mainimage->thumbnails->smallThumb}}" alt="Imagen referencial"
             style="max-width: 240px;aspect-ratio: 1/1;object-fit: contain;">
      @endif
    </td>
    
    <td width="50%">
      <p style="margin: 0 0 18px; color: #212529;font-size: 16px;">
        <strong>{{ $reservation->gamma->title }}</strong><br>
        <strong>{{ $reservation->gamma->summary }}</strong>
      </p>
      <p style="margin: 0 0 5px; color: #555;font-size: 16px;">
        👩 {{ $reservation->gamma->passengers_number }}{{ ' ' . itrans('irentcar::email.passengers') }}
      </p>
      <p style=" margin: 0; color: #555;font-size: 16px;">
        🧳 {{ $reservation->gamma->luggage }}{{ ' ' . itrans('irentcar::email.luggage') }}
      </p>
    </td>
  </tr>
</table>

<hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">

@if (!empty($reservation->extras_data))
  <h2 style="font-size: 22px; margin-bottom: 25px; color: #212529;">
    {{itrans('irentcar::email.extras')}}
  </h2>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style=" ">
    @foreach ($reservation->extras_data as $extra)
      
      <tr>
        <td style=" margin: 0 0 10px; color: #555;font-size: 15px;">
          <strong>{{ $extra['extra']['title'] }}</strong><br>
          <span style="color: #555;">{{ $extra['extra']['description'] }}</span><br>
        </td>
        <td>
          ${{$extra['price']}} COP
        </td>
      </tr>
    
    @endforeach
  </table>
  
  <hr style="background-color: transparent;border: 0.5px solid #e2e2e2; margin:40px 0;">
@endif