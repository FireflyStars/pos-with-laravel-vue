@if(isset($dataTypeContent->{$row->field}))
    <div data-field-name="{{ $row->field }}">
        <a href="#" class="voyager-x remove-single-image" style="position:absolute;"></a>
        <img src="@if( !filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $dataTypeContent->{$row->field} ) }}@else{{ $dataTypeContent->{$row->field} }}@endif"
          data-file-name="{{ $dataTypeContent->{$row->field} }}" data-id="{{ $dataTypeContent->getKey() }}"
          style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" id="{{$dataType->name}}_{{$row->field}}">
    </div>

    @if( !filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL))
        @if(in_array($dataType->name.".".$row->field,['campagne_category.imagetemplate']))
            <a href="javascript:void(0);" class="btn btn-default loadPosModal" id="btn_modal_{{ $dataTypeContent->getKey() }}" onclick="loadPosModal({{ $dataTypeContent->getKey() }},'@php echo  Voyager::image( $dataTypeContent->{$row->field} ); @endphp')">Position text</a>
        @endif
    @endif
@endif
<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file" name="{{ $row->field }}" accept="image/*">
