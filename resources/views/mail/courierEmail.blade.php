@component('mail::message')
# Courier Email

{!! $campagne_category->infoimprimeur !!}

Flyer: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urlflyer . '&filename=flyer.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urlflyer . '&filename=flyer' }}
</a>

Letter: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urllettre . '&filename=letter.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urllettre . '&filename=letter' }}
</a>

Deplyant: <a href="{{ $url . '/download-resource-file?resource=' . optional($campagne_category->filedepliant)->first()['download_link'] . '&filename=deplyant.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . optional($campagne_category->filedepliant)->first()['download_link'] . '&filename=deplyant' }}
</a>

Envelop: <a href="{{ $url . '/download-resource-file?resource=' . optional($campagne_category->fileenveloppe)->first()['download_link'] . '&filename=envelop.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . optional($campagne_category->fileenveloppe)->first()['download_link'] . '&filename=envelop' }}
</a>

Csv: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urlcsv . '&filename=Cilbe Info.csv' }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urlcsv . '&filename=csv' }}
</a>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
