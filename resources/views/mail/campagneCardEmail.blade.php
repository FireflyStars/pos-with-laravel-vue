<style>
    p {
        margin-bottom: .5rem !important;
    }
    .address p {
        margin-bottom: .05rem !important;
        font-size: 11px;
    }
    .address-section {
        float: right;
    }
    .address-section::before, 
    .address-section::after  {
        clear: both;
        float: none;
    }
</style>

@component('mail::message')
Campagne Produit

@component('mail::table')
| Name          | Qty           | Price     |  Tax     | Description  | Pdf |
| :-------------: | :-------------: | :-------------: | :-------------: | :-------------: | :-------------: |
@foreach ($campagne->details as $product)
@php
    $tax = $product->tax->taux * $product->price;
    $taxPrice = $product->price + $tax;
    $fileUrl = $url . '/download-resource-file?resource=' . $product->urlpdf . '&filename=' . date('Ymd-hi') . 'Product.pdf';
@endphp
| {{ $product->name }} | {{ $product->qty }} | {{ $product->price }} &euro;  |  {{ $taxPrice }} &euro; | {!! $product->description !!} | @if(!is_null($product->urlpdf))<a href="{{ $fileUrl }}">Download pdf</a> @endif |
@endforeach

@endcomponent

<p><strong>Total HT</strong>: {{ $total }} &euro; &nbsp; SOIT {{ $tax }} &euro; TTC </p>
<p><strong>Total TTC</strong>: {{ $total_with_tax }} &euro;</p>


<p><strong>Address of livraison</strong></p>

<div class="address" stye="float:right">
    <p>{{ $campagne->affiliate->address }} </p>
    <p>{{ $campagne->affiliate->address2 }} </p>
    <p>{{ $campagne->affiliate->postcod }} </p>
    <p>{{ $campagne->affiliate->city }} </p>
    <p>{{ $campagne->affiliate->firstnamedirector }} </p>
    <p>{{ $campagne->affiliate->namedirector }}</p>
    <p>{{ $campagne->affiliate->email }} </p>
    <p>{{ $campagne->affiliate->telephone }}</p>
</div>

<p style="float: none; clear: both;"></p>

<br>


Merci,<br>
{{ config('app.name') }}
@endcomponent
