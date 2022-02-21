@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #modalDraggable{
            border:thin solid #000;
        }

        .textpos{
            font-size:14pt;
            position: absolute;
            top:0;
            left:0;
        }

        .textpos.active-text{
            background:rgba(255,255,255,0.5);
        }

        .textpos:hover{
            cursor: move;
        }

        .remove-img-pos{
            font-size:20pt;
            margin-top: -10px;
        }
    </style>
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                @endphp
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    {{ $row->slugify }}
                                    <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if (isset($row->details->view))
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

<!--Modal positiioning -->

<div id="modal_pos" class="modal fade">
    <div class="modal-dialog" role="document" style="width:auto !important;">
        <div class="modal-content" style="display:table; margin:auto;">
            <div class="modal-header">
                <h5 class="modal-title float-left">Positionner text sur image</h5>
                <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Fermer</button>
            </div>
            <div class="modal-body" style="display:table; width:1100px;">
                <div class="modalPosDiv float-left" id="div_modal_{{ $dataTypeContent->getKey() }}" style="background-size:auto 100%; width:800px;">

                    <div id="modalDraggable" style="width:800px; height:500px; background:rgba(0,0,0,0.5); position: relative;">
                        <span id="textpos_1" class="textpos">Nom agence</span>
                        <span id="textpos_2" class="textpos">Email agence</span>
                        <span id="textpos_3" class="textpos">Telephone agence</span>
                    </div>
                </div>
                <div class="float-left" style="width:250px; padding-left:15px;">

                    <div style="margin-bottom:20px;">
                        <h5>Nom Agence: </h5>
                        Position X: <span id="textpos_1_x" class="pos_coords"></span><br/>
                        Position Y: <span id="textpos_1_y" class="pos_coords"></span>
                    </div>

                    <div style="margin-bottom:20px;">
                        <h5>Email Agence: </h5>
                        Position X: <span id="textpos_2_x" class="pos_coords"></span><br/>
                        Position Y: <span id="textpos_2_y" class="pos_coords"></span>
                    </div>

                    <div style="margin-bottom:20px;">
                        <h5>Telephone agence </h5>
                        Position X: <span id="textpos_3_x" class="pos_coords"></span><br/>
                        Position Y: <span id="textpos_3_y" class="pos_coords"></span>
                    </div>

                    <a href="javascript:void(0);" class="btn btn-default" onclick="updateTextCoords({{ $dataTypeContent->getKey() }})">Sauvegarder</a>
                </div>

                <div style="margin:20px 0;">

                </div>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="cur_id" value="{{ $dataTypeContent->getKey() }}"/>
    <!-- End Delete File Modal -->
@stop

@section('javascript')

<script type="text/javascript" src="/jquery/jquery-ui/jquery-ui.min.js"></script>

    <script>
        var params = {};
        var $file;

        let cur_id = $('#cur_id').val();


        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); });

                        $('#btn_modal_'+params.id).remove();


                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();

            $('.textpos').draggable({
                containment: "#modalDraggable",
                scroll: false,
                stop: function(ev, ui){
                   let el = $(ev.target);
                   let id = el.attr('id');
                    //console.log(id);

                    var position = ui.position;
                    var originalPosition = ui.originalPosition;
                   //console.log(position);
                    $('#'+id+'_x').html(parseFloat(position.left));
                    $('#'+id+'_y').html(parseFloat(position.top));

                  }
            });

            $('.textpos').click(function(){
                let el = $(this);

                $('.textpos').not(this).removeClass('active-text');
                el.toggleClass('active-text');
            });


            $(document).bind('keydown', function(e) {
                let activetexts = $('.active-text');

                //console.log(e);
                //console.log(activetexts);

                if(activetexts.length > 0){

                    var position,
                        draggable = $('.active-text'),
                        container = $('#div_modal_'+cur_id),
                        distance = 1; // Distance in pixels the draggable should be moved

                    position = draggable.position();

                    // Reposition if one of the directional keys is pressed
                    switch (e.keyCode) {
                        case 37: position.left -= distance; break; // Left
                        case 38: position.top  -= distance; break; // Up
                        case 39: position.left += distance; break; // Right
                        case 40: position.top  += distance; break; // Down
                        default: return true; // Exit and bubble
                    }

                    // Keep draggable within container
                    if (position.left >= 0 && position.top >= 0 &&
                        position.left + draggable.width() <= container.width() &&
                        position.top + draggable.height() <= container.height()) {
                        draggable.css(position);
                    }

                    let id = draggable.attr('id');

                    $('#'+id+'_x').html([position.left]);
                    $('#'+id+'_y').html([position.top]);


                    // Don't scroll page
                    e.preventDefault();
                }
            });



        });



        function loadPosModal(id,imageUrl){
            let params = {};
            params['id'] = id;

            let color1 = $('input[name=color1]').val();
            let color2 = $('input[name=color2]').val();
            let color3 = $('input[name=color3]').val();

            $('#textpos_1').css('color',(color1!=''?color1:'#000'));
            $('#textpos_2').css('color',(color2!=''?color2:'#000'));
            $('#textpos_3').css('color',(color3!=''?color3:'#000'));


            $.post('/admin/get-text-pos', params, function (response) {
                if(response.cc){
                    let cc = response.cc;

                    $('#textpos_1').css('left',cc.xfield1+'px');
                    $('#textpos_1_x').html(cc.xfield1);
                    $('#textpos_1').css('top',cc.yfield1+'px');
                    $('#textpos_1_y').html(cc.yfield1);

                    $('#textpos_2').css('left',cc.xfield2+'px');
                    $('#textpos_2_x').html(cc.xfield2);
                    $('#textpos_2').css('top',cc.yfield2+'px');
                    $('#textpos_2_y').html(cc.yfield2);

                    $('#textpos_3').css('left',cc.xfield3+'px');
                    $('#textpos_3_x').html(cc.xfield3);
                    $('#textpos_3').css('top',cc.yfield3+'px');
                    $('#textpos_3_y').html(cc.xfield3);


                }
            }).done(function() {
                //alert( "second success" );
            })
            .fail(function() {
                //alert( "error" );
            })
            .always(function() {
                //alert( "finished" );
                $('#div_modal_'+id).css('background-image', 'url(' + imageUrl + ')');
                $('#modal_pos').modal('show');
            });
        }


        function updateTextCoords(id){
            let params = {};
            params['id_cc'] = id;

            $('.textpos').removeClass('active-text');

            $('body').find('.pos_coords').each(function(i,v){
                let el = $(v);
                let  id = el.attr('id');
                params[id] = el.html();
            });

            $.post('/admin/update-text-pos', params, function (response) {
                    console.log(response);
                    if ( response.updated) {

                        toastr.success('Position sauvegardé');


                    } else {
                        //toastr.error("Error removing file.");
                    }
                });


        }


    </script>
@stop
