@extends('dashboard.layouts.master')
@section('title', __('messages.Roles') )
@section('content')

    <div class="modal" id="modaldemo8" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('messages.Delete Operation') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <ul id="list_error_message3"></ul>
                <div class="modal-body">
                    <p>{{ __('messages.Are sure of the deleting process ?') }}</p><br>
                    <input class="form-control" id="nameDetele" type="text" readonly="">
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">{{ __('messages.Close') }}</button>
{{--                    {!! Form::open(['method' => 'DELETE', 'id' => 'deleteForm']) !!}--}}
{{--                    {!! Form::submit(__('messages.Delete'), ['class' => 'btn btn-danger']) !!}--}}
{{--                    {!! Form::close() !!}--}}
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="row row-xs wd-xl-80p">
                        <div class="col-sm-6 col-md-3 mg-t-10">
                            <a href="{{route('roles.create')}}" class="btn btn-info-gradient btn-block"
                                    style="font-weight: bold; color: beige;">{{ __('messages.add') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table-container">
                        <table class="table table-hover" id="roles" style=" text-align: center;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('messages.Name')}}</th>
                                <th>{{__('messages.Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>

                                        @can('update roles')
                                            <a href="{{ route('roles.edit', $role->id) }}" type="button" class="btn btn-info mr-2"><i class="bi bi-pencil-fill"></i></a>
                                        @endcan

                                        @if ($role->name !== 'Admin')
                                            @can('delete roles')
                                                    <button type="button" class="btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                            @endcan
                                        @endif

                                            @can('display roles')
                                                <a class="btn btn-success mr-2" type="button"
                                                   href="{{ route('roles.show', $role->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                                                </a>
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // jQuery.noConflict();
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');

            $('#nameDetele').val(name); // Display the name in the delete confirmation modal

            // Show the delete confirmation modal
            $('#modaldemo8').modal('show');

            // Click event for the "Delete" button in the modal
            $(document).off("click", "#deleteForm").on("click", "#deleteForm", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Update the AJAX call to GET
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("roles.destroy", ":id") }}'.replace(':id', id),
                    // Pass data as query parameters in the URL
                    success: function(response) {
                        $('#modaldemo8').modal('hide');
                        reloadTable();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
        function reloadTable() {
            $.ajax({
                type: 'GET',
                url: '{{ route("roles.index") }}', // Replace with the route that returns the updated table content
                success: function(response) {
                    // Update the table content with the new HTML data
                    $('#table-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>

@stop
