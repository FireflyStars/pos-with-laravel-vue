<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Courier LCDT AMO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        
        body {
            font-size: 16px;
            width: 100%;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .contenu {
            width: 100%;
            font-size: small;
            color: black;
            padding: 50px;
            padding-left: 4rem;
            padding-right: 4rem;
            font-style: normal;
            font-size: 14px !important;
            line-height: 20px;
        }

        .content {
            word-wrap: break-word !important;
            line-height: 1.7;
            padding-right: 4rem;
            text-align: justify;
        }

        .text_footer {
            padding: 0 3px;
            font-weight: bold;
            margin-top: -1px;
            line-height: 1.7;
        }

        #footer {
            float: right;
            margin-top: 1rem;
            padding-left: 4rem;
            padding-right: 4rem;
        }

        .row {
            display: flex !important;
            justify-content: space-between;
        }

        .pt-3 {
            padding-top: 1rem;
        }

        .pt-5 {
            margin-top: 3rem;
        }

        .grid-4-8 {
            display: grid !important;
            grid-template-columns: 8fr 4fr !important;
        }

        .clearfix {
            float: none;
            clear: both;
        }

    </style>
</head>
<body>


    @foreach ($campagne->campagneCible as $cible)
        <?php
            $break_rule = $loop->last ? 'avoid-page': 'always';
            $background = $builder->convert_base64(rtrim(public_path(), '/') . '/' . 'images/background_letter.jpg');
        ?>
        <div    
            class="template-email" 
            style="
                page-break-after: {{ $break_rule }} !important;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            "
        >
            <img 
                src="{{ $background }}" 
                alt="Letter Background" 
                style="width: 100%; height: 100%; position: fixed; z-index: -1; object-fit: cover;"
            >
            
            <div class="contenu">
        
                <div style="margin-top: 7rem;">
                    <div class="column" style="float: left">
                        <div>
                            <b>LA COMPAGNIE DES TOITS</b>
                        </div>
                        <div><b>Agence {{ optional($campagne->affiliate)->name }}</b></div>
                        <div>{{ optional($campagne->affiliate)->address }}</div>
                        <div>{{ optional($campagne->affiliate)->postcode . " " . optional($campagne->affiliate)->city }}</div>
                        <div>{{ $campagne->email }}</div>
                        <div>{{ $campagne->phone }}</div>
                    </div>

                    <div class="column" style="margin-top: 4.2rem; float: left; margin-left: 6rem;">
                        <div>{{ $cible->company }}</div>
                        <div>{{ $cible->firstname . " " . $cible->name }}</div>
                        @if($cible->address1)<div>{{ $cible->address1 }}</div>@endif
                        @if($cible->address2)<div>{{ $cible->address2 }}</div>@endif
                        @if($cible->address3)<div>{{ $cible->address3 }}</div>@endif
                        <div>{{ $cible->postcode . " " . $cible->city }}</div>
                        <div style="margin-top: 3rem;">
                            {{ optional($campagne->affiliate)->city }}, {{ now()->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="letter-recipient" style="margin: 3rem 0;">
                    {{ optional($cible->contact)->gender ?? 'Mrs' }},
                </div>

                <div class="content" style="margin-right: 4rem;">
                    {!! $data['content'] !!}
                </div>

            </div>

            <div id="footer">
                <div class="text_footer">
                    <div>
                        {{ optional($campagne->affiliate)->firstnamedirector }} {{ optional($campagne->affiliate)->namedirector }}
                    </div>
                    <div style="color: orangered">
                        Dirigeant de l’agence {{ optional($campagne->affiliate)->name }}
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>

    @endforeach
    
</body>
</html>