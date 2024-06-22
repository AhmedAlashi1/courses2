    <div class="col-{{$size}}">
        <div class="form-group">
            <label>{{$title}}   </label>
            {!! Form::textarea($name,null,['class'=>'form-control ckeditor','placeholder'=>$title])!!}
            <p class="help-block"></p>
            @error($name)
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
    </div>
