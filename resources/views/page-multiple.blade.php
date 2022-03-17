<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multiple Pages Reports</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-size: 16px;
        }
        main {
            position: relative;
            width: 90%;
            margin: 1rem auto;
            min-height: 45rem;
            max-height: 55rem;
        }
        .draggable, .item {
            z-index: 10;
            position: absolute;
        }
        button {
            display: flex;
            align-items:center;
            gap: 4px;
            padding: 7px 18px;
            position: relative;
            background: #ECECEC;
            border: 1px solid #47454B;
            box-sizing: border-box;
            border-radius: 4px;
            text-align: left;
            font-family: 'Almarai';
            font-style: normal;
            font-weight: bold;
            font-size: 16px;
            line-height: 140%;
            transition: all .1s;
            max-width: 91px;
            max-height: 38px;
        }
        button.danger {
            background: #FF0000;
            color: white;
        }
        button.green {
            background: #A1FA9F;
            color: #3E9A4D;
        }
        button.light-green, button.lightgreen {
            background: rgba(161, 250, 159, 0.47);
            color: rgba(0, 0, 0, 0.2);
        }
        button.primary {
            background: #1FB9FC;
            color: #fff;
        }
        button.success {
            background: #3E9A4D;
            color: white;
        }
        button.light-warning, button.lightWarning {
            background: rgba(232, 88, 27, 0.7);
            color: white;
        }
        button.warning {
            background: #E8581B;
            color: white;
        }
        .order-1 {
            order: 1 !important;
        }

        .template-header {
            top: 0;
            max-height: 4.75rem !important;
        }
        .template-footer {
            bottom: 0;
            max-height: 4.75rem !important;
        }
        .template-header,  
        .template-footer {
            width: 100%;
            position: absolute;
            left: 0;
        }
        .template-footer img,
        .template-footer img {
            width: 100%;
            height: 100%;
            padding: 1rem;
            object-fit: cover;
        }
        .template-body {
            margin-top: 6.75rem;
        }
        .template-body span {
            word-break: break-all !important;
        }
        .template-body img {
            width: auto;
            height: auto;
            object-fit: cover;
            width: 25rem;
            height: 25rem;
            border: 3px solid orange;
            position: absolute;
        }

        .template-body .svg {
            width: 35px;
            height: 30px;
            border: none;
        }

        .draggable {
            cursor: move;
            z-index: 10;
            position: absolute;
        }

        .transparent-button {
            background: transparent;
            border-radius: 0;
            border: 2px solid #000;
            text-transform: uppercase;
            font-weight: 900;
            font-family: 'Almarai ExtraBold';
        }

        .title-bar {
            background: #797272;
            color: rgb(243, 243, 243);
            padding: 5px 1rem;
            margin: .8rem 0;
            text-transform: uppercase;
            font-size: 1.2rem;
            font-weight: 900;
            font-family: 'Almarai ExtraBold';
            width: 100%;
            display: flex;
            align-items: center;
        }

        .textarea {
            position: absolute !important;
            border: none;
            min-width: 350px;
            min-height: 50px;
            border: 1px solid #ccc;
            z-index: 99999;
            word-wrap: normal;
        }
       
        .textarea::before,
        .textarea::after {
            float: none;
            clear: both;
        }
        
    </style>

</head>

<body>
   
    @foreach ($pages as $page)
        <?php $break_rule = $loop->last ? 'avoid-page': 'page';  ?>
        <main style="break-after: {{ $break_rule }}; position: relative;">

            <div class="template-header" style="max-height: 6rem; position: absolute; top: 0; left: 0">
                <img 
                    v-if="templates.length"
                    src="{{ $builder::get_active_template($page->template_id)['template']['header'] }}" 
                    alt="Template header"
                    style="width: 90%; height: 6rem;"  
                >
            </div>
        
            <div class="template-body">
                
                @foreach ($page->elements as $element)
                    
                    @if (strtolower($element->name) == 'button')
                        <button 
                        class="{{ $element->attributes->kind ?? 'default' }} {{ $element->attributes->class }}" 
                        style="{{ $element->attributes->style ?? '' }}">
                            {{ $element->attributes->title ?? '' }}
                        </button>
                    @endif
        
                    @if (strtolower($element->name) == 'textarea')
                        <div 
                        class="{{ $element->attributes->class }}" 
                        style="{{ $element->attributes->style ?? '' }} position: absolute;"
                        >{!! $element->content ?? '' !!}
                        </div>
                    @endif
            
                    @if (strtolower($element->name) == 'svg')
                        <?php 
                            
                            $name = $svgs[$element->attributes->name];
                            $src = 'data:image/svg+xml;base64,' . base64_encode($name);
                        ?>
                        <img 
                            class="{{ $element->attributes->class ?? 'draggable' }} svg"
                            src="{{ $src }}" 
                            style="{{ $element->attributes->style ?? '' }}" 
                        /> 
                    @endif    
            
                    @if (strtolower($element->name) == 'img')
                        <?php
                            $src = $element->prefetched 
                            ? $builder::convert_base64(public_path('\/storage/' . $element->dataFile))
                            : $builder::convert_resource_file("Img#".$element->attributes->id);
                        ?>
                        <img 
                            class="{{ $element->attributes->class ?? 'draggable' }}"
                            src="{{ $src }}" 
                            style="{{ $element->attributes->style ?? '' }}" 
                        /> 
                    @endif    
            
                @endforeach
        
            </div>
        
            <div class="template-footer" style="max-height: 6rem; position: absolute; bottom: 0; left: 0">
                <img 
                    src="{{ $builder::get_active_template($page->template_id)['template']['footer'] }}" 
                    alt="Template footer"
                    style="width: 90%; max-height: 6rem;" 
                >
            </div>

        </main>
        
    @endforeach

</body>
</html>