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

<h3 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">{{itrans('irentcar::email.car information')}}</h3>

<p style="margin: 0; color: #000;"> <strong>{{ $reservation->gamma->title }}</strong></p>
<p style="margin: 0; color: #5B6077; font-size: 14px;">{{ $reservation->gamma->passengers_number }}
    {{itrans('irentcar::email.passengers')}}
</p>
<p style="margin: 0; color: #5B6077;font-size:14px;">{{ $reservation->gamma->luggage }}
    {{itrans('irentcar::email.luggage')}}
</p>


@if(!empty($filesByZone) && isset($filesByZone->mainimage))
    <img src="{{ $filesByZone->mainimage->thumbnails->smallThumb}}" alt="Imagen referencial" style="max-width: 200px;">
@endif

<hr style="color:#62748E4D">

<h3 style="font-size: 20px; margin-bottom: 10px; color: #172E3F;">{{itrans('irentcar::email.extras')}}</h3>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style=" ">
    @foreach ($reservation->extras_data as $extra)

        <tr>
            <td style="padding: 15px;">
                <strong>{{ $extra['extra']['title'] }}</strong><br>
                <span style="color: #888;">{{ $extra['extra']['description'] }}</span><br>
            </td>
            <td>
                ${{$extra['price']}} COP
            </td>
        </tr>

    @endforeach
</table>


<hr style="color:#62748E4D">