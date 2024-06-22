<div class="col-{{$size??12}}">
    <div class="form-group">
        <label>{{$title}}</label>
        {!! Form::email($name,null,['placeholder'=>"$title",'class'=>'form-control ']+$options) !!}
        <p class="help-block"></p>
        @error($name)
        <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
</div>
