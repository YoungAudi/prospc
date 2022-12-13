<div class="fv-row elc_{{$name}} {{$mb ?? 'mb-8'}}">
    @if(isset($label) && $label != '')
    <label class="form-label">{{$label}}</label>
    @endif
    <select @if($disabled) disabled="true" readonly="true" @endif  @if(isset($select2) && $select2) data-control="select2" data-placeholder="{{$placeholder??''}}" @endif value="{{$value??''}}" name="{{$name}}" autocomplete="off" class="fca form-select {{$classes ?? ''}} bg-transparent">
        @if($placeholder != '')
        <option value="" @if($value=="") selected @endif>{{$placeholder}}</option>
        @endif
        @foreach($options as $optValue => $option)
        <option value="{{$optValue}}" @if($value==$optValue) selected @endif>{{$option}}</option>
        @endforeach
    </select>
</div>