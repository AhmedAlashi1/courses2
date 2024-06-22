@can('delete admins')
    <button type="button" class="btn btn-danger delete-btn" data-url="{{ route('admins.destroy',$id) }}" data-name="{{ $name }}"><i class="bi bi-trash-fill"></i></button>
@endcan

@can('update admins')
    <a href="{{route('admins.edit',$id)}}" type="button" class="btn btn-info mr-2"><i class="bi bi-pencil-fill"></i></a>
@endcan




