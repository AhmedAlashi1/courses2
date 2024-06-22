
@can('delete users')
    <button type="button" class="btn btn-danger delete-btn" data-url="{{ route('users.destroy', $id) }}" data-name="{{ $name }}"><i class="bi bi-trash-fill"></i></button>
@endcan



{{--@can('edit users')--}}
    <a href="{{route('buy_course_user.index',$id)}}" type="button" class="btn btn-info mr-2">الدورات المدفوعة</a>

{{--@endcan--}}

