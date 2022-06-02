<style>
    p {
        margin-bottom: .5rem !important;
    }
    .address p {
        margin-bottom: .05rem !important;
        font-size: 11px;
    }
</style>

@component('mail::message')
Campagne Courrier

@component('mail::table')
| Name          | Qty           | Price     |  Tax     | Description  |
| :-------------: | :-------------: | :-------------: | :-------------: | :-------------: |
@foreach ($campagne->details as $product)
@php
    $tax = $product->tax->taux * $product->price;
    $taxPrice = $product->price + $tax;
@endphp
| {{ $product->name }} | {{ $product->qty }} | {{ $product->price }} &euro;  |  {{ $taxPrice }} &euro; | {!! $product->description !!} |
@endforeach

@endcomponent

<p><strong>Total HT</strong>: {{ $total }} &euro; &nbsp; SOIT {{ $tax }} &euro; TTC </p>
<p><strong>Total TTC</strong>: {{ $total_with_tax }} &euro;</p>
<p><strong>Address of livraison</strong></p>

<div class="address">
    <p>{{ $campagne->affiliate->address }} </p>
    <p>{{ $campagne->affiliate->address2 }} </p>
    <p>{{ $campagne->affiliate->postcod }} </p>
    <p>{{ $campagne->affiliate->city }} </p>
    <p> {{ $campagne->affiliate->firstnamedirector }} </p>
    <p>{{ $campagne->affiliate->namedirector }}</p>
    <p>{{ $campagne->affiliate->email }} </p>
    <p>{{ $campagne->affiliate->telephone }}</p>
</div>


Merci,<br>
{{ config('app.name') }}
@endcomponent
