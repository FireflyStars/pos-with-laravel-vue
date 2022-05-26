@component('mail::message')
Campagne Courrier

{!! $campagne_category->infoimprimeur !!}

Flyer: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urlflyer . '&filename=flyer.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urlflyer . '&filename=flyer' }}
</a>

Lettre: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urllettre . '&filename=letter.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urllettre . '&filename=letter' }}
</a>

Dépliant: <a href="{{ $url . '/download-resource-file?resource=' . $filedepliant . '&filename=deplyant.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $filedepliant . '&filename=deplyant' }}
</a>

Enveloppe: <a href="{{ $url . '/download-resource-file?resource=' . $fileenveloppe . '&filename=envelop.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $fileenveloppe . '&filename=envelop' }}
</a>

Csv: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urlcsv . '&filename=Cilbe Info.csv' }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urlcsv . '&filename=csv' }}
</a>


Merci,<br>
{{ config('app.name') }}
@endcomponent
