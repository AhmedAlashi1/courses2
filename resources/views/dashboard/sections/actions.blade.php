
{{--@can('delete sections')--}}
    <button type="button" class="btn btn-danger delete-btn"
            data-url="{{ route('section.destroy', $id) }}" data-name="{{ $name }}">
        <i class="bi bi-trash-fill"></i></button>
{{--@endcan--}}

{{--@can('update sections')--}}
    <a href="{{route('section.edit',$id)}}" type="button" class="btn btn-info mr-2"><i class="bi bi-pencil-fill"></i></a>

    <a href="{{route('videos.index',[$courses_id,$id])}}" type="button" class="btn btn-info mr-2">الفيديوهات</a>

{{--@endcan--}}

