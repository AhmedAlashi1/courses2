@props(['name','title','size'=>6])
<div class="col-{{$size}}">
    <div class="form-group">
        <label>{{$title}}</label>
        {!! Form::password($name,['placeholder'=>"$title",'class'=>'form-control ']) !!}
        <p class="help-block"></p>
        @error($name)
        <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
</div>
