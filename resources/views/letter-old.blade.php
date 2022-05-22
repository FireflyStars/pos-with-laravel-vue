<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Letter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-size: 16px;
            overflow: hidden !important;
            width: 100%;
            height: 100%;
        }

        .template-email {
            border: black 2px solid !important;
        }

        .contenu {
            width: 100%;
            font-size: small;
            color: black;
            padding: 50px;
            font-style: normal;
            font-size: 13px !important;
            line-height: 20px;
        }

        span {
            color: black;
            font-size: xx-small;
        }

        .text_footer {
            background: white;
            padding: 0 3px;
            font-size: xx-small;
            font-weight: bold;
            margin-top: -1px;
        }

        #footer {
            width: 389px;
            display: flex;
            justify-content: flex-end;
            background-color: orangered;
            margin-top: auto;
            height: 10px;
            padding: 0 40px 0 0;
            margin-bottom: 20px;
        }

        .apercu h6 {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
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

    </style>
</head>
<body>

    <div    
        class="template-email" 
        style="
            width: 389px !important;
            height: 668px !important;
            overflow: hidden;
        "
    >
        <div class="contenu">
            <div class="row auth-logo">
                <div class="col-6 p-lg-0 d-flex align-items-center">
                    <img 
                        src="{{ $builder::convert_base64(public_path() . '/' . 'images/logolcdt.png') }}" 
                        alt="Logo Lcdt"
                        style="height: 55px;"
                    >
                </div>
            </div>
            <div class="row pt-5" style="display:flex; justify-content: space-between;">
                <div class="column">
                    <div>
                        <b>expediteur</b>
                    </div>
                    <div>expediteur2</div>
                    <div>adresse</div>
                    <div>adresse2</div>
                    <div>Tel. coord</div>
                    <div>email</div>
                </div>

                <div class="column">
                    <div>SARL</div>
                    <div>Civilité Prénom Nomn</div>
                    <div>310 Route de l'Odyssée</div>
                    <div>45700 CONFLANS SUR LOING</div>
                </div>
            </div>
            <div class="row pt-3" style="display: flex; justify-content: space-between;">
                <div class="column col-6"></div>

                <div class="column col-6">
                    <div>Chilly Mazarin, le XX juin 2021</div>
                </div>
            </div>
            <div>Madame X, Monsieur Y, Madame, Monsieur,</div>

            <div class="pt-3">
                {!! $data['content'] !!}
            </div>

            <div 
                class="grid-4-8 pt-5" 
                style="display: grid !important;
                grid-template-columns: 8fr 4fr !important;"
            >
                <div class="column col-8"></div>
                <div class="column col-4">
                    <div><b> L’équipe commerciale</b></div>
                    <div>Agence X</div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="text_footer">
                <span>LE RESEAU EXPERT </span>
                <span style="color: orangered">DES TOITS PROFESSIONNELS</span>
            </div>
        </div>
    </div>
    
</body>
</html>