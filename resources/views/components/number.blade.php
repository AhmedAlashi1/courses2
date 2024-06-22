<div class="col-{{$size??12}}">
    <div class="form-group">
        <label>{{$title}}</label>
        {!! Form::number($name,$slot == ''?null: $slot,['placeholder'=>"$title",'class'=>'form-control ']+$options) !!}
        <p class="help-block"></p>
        @error($name)
        <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
</div>
