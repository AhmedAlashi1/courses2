<div class="col-{{$size??12}}">
    <div class="form-group">
        <label>{{$title}}</label>
        {!! Form::select($name,$items,$slot == ''?null:$slot,['class'=>'form-control select2']+$options) !!}
        <p class="help-block"></p>
        @error($name)
        <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
</div>
