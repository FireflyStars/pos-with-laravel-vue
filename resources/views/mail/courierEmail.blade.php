@component('mail::message')
Campagne Courrier

{!! $campagne_category->infoimprimeur !!}

@php
    $filenames = [
        'flyer'  => 'flyer-' . date('dmY-hi') . '.pdf',
        'letter' => 'lettre-' . date('dmY-hi') . '.pdf',
        'csv'    => 'csv-' . date('dmY-hi') . '.csv'
    ];
@endphp

Flyer: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urlflyer . '&filename=' . $filenames['flyer'] }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urlflyer . '&filename=' . $filenames['flyer'] }}
</a>

Lettre: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urllettre . '&filename=' . $filenames['letter'] }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urllettre . '&filename=' . $filenames['letter'] }}
</a>

Dépliant: <a href="{{ $url . '/download-resource-file?resource=' . $filedepliant . '&filename=deplyant.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $filedepliant . '&filename=deplyant' }}
</a>

Enveloppe: <a href="{{ $url . '/download-resource-file?resource=' . $fileenveloppe . '&filename=envelop.pdf' }}">
    {{ $url . '/download-resource-file?resource=' . $fileenveloppe . '&filename=envelop' }}
</a>

Csv: <a href="{{ $url . '/download-resource-file?resource=' . $campagne->urlcsv . '&filename=' . $filenames['csv'] }}">
    {{ $url . '/download-resource-file?resource=' . $campagne->urlcsv . '&filename=' . $filenames['csv'] }}
</a>


Merci,<br>
{{ config('app.name') }}
@endcomponent
