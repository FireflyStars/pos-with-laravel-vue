<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Flyer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 514px !important;
            height: 781px !important;
            overflow: hidden;
        }
        .link {
            position: absolute;
            top: 53px;
            left: 52px;
            color: rgb(223, 0, 0);
            font-size: 12px;
            font-family: arial;
        }
        .info {
            position: absolute;
            color: rgb(0, 0, 0);
            font-size: 12px;
            font-family: arial;
            top: 149px;
            left: 322px;
            line-height: 18px;
        }

        .contact-info {
            position: relative;
            color: rgb(255, 255, 255);
            font-size: 12px;
            font-family: arial;
            top: 559px;
            left: 128px;
        }

        .item {
            position: absolute;
        }


    </style>
</head>

<body>

    @php
        $backgroundImage = $builder::convert_base64(public_path() . '/storage' . '/' . $data['image']);
    @endphp
    <div 
        class="container"
        style="
            background-image: url('{{ $backgroundImage }}'); 
            background-size: 514px 781px; 
            background-position: center; 
            background-repeat: no-repeat;
            position: relative;
        "
    >
        
        @foreach ($data['fields'] as $key => $item)

            @php $item = (array) $item; @endphp

                @if (isset($item['active']) && $item['active'] == 1)

                    <span 
                        class="item" 
                        style="color: {{ $item['color'] }}; 
                        font-size: {{ $item['size'] }}px; 
                        font-family: {{ $item['font']}}; 
                        top: {{ $item['y'] }}px;
                        left: {{ $item['x'] }}px;"
                    >

                        @if ((strtolower($key) != "email_egence" && strtolower($key) != "telephone_agence"))
                            {{ $item['value'] }}
                            @elseif (strtolower($key) == 'email_agence')
                                {{ $item['value'] }}
                            @elseif (strtolower($key) == 'telephone_agence')
                                {{ $item['value'] }}    
                        @endif

                    </span>

                @endif
                
        @endforeach

    </div>
   
</body>

</html>