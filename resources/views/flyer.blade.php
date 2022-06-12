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
        body {
            width: 100% !important;
            height: 100% !important;
        }
        .container {
            width: 100% !important;
            height: 100% !important;
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
        .item {
            position: absolute;
        }
    </style>
</head>

<body>

    @for ($i = 0; $i < 2; $i++)
        
        @php
            $break_rule = $i == 0 ? 'always' : 'avoid-page';
            if ($i == 0) 
            {
                $backgroundImage = $builder::convert_base64(public_path() . '/storage' . '/' . $data['image']);
            }
            else {
                $backgroundImage = $builder::convert_base64(public_path() . '/storage' . '/' . $data['image2']);
            }
        @endphp

        <div 
            class="container"
            style="
                page-break-after: {{ $break_rule }} !important;
                position: relative;
            "
        >
            <img 
                src="{{ $backgroundImage }}" 
                alt="Flyer background"
                style="width: 100%; height: 100%; object-fit: cover; position: fixed; z-index: -1"
            >
            @if ($i == 1)

                @foreach ($data['fields'] as $key => $item)

                    @php $item = (array) $item; @endphp
                    @if (isset($item['active']) && $item['active'] == 1)
                        @php
                           $y = $item['y'] - 0; 
                        @endphp
                        <span 
                            class="item" 
                            style="color: {{ $item['color'] }}; 
                            font-size: {{ $item['size'] }}px; 
                            font-family: {{ $item['font']}}; 
                            top: {{ $y }}px;
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

            @endif

        </div>

    @endfor

   
</body>

</html>