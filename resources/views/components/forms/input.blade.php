<div class="fv-row elc_{{$name}} {{$mb ?? 'mb-8'}}">
    @if(isset($label) && $label != '')
    <label class="form-label">{{$label}}</label>
    @endif
    <input @if(isset($model)) x-model="{{$model}}" @endif  @if($disabled) disabled="true" readonly="true" @endif value="{{$value??''}}" type="{{$type??'text'}}" placeholder="{{$placeholder??$name}}" name="{{$name}}" autocomplete="off" class="fca form-control {{$classes ?? ''}} bg-transparent" />
</div>