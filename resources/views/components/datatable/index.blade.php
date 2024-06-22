@props([
    'title',
    'dataTable'
])

@extends('dashboard.layouts.master')
@section('title', $title)
@section('content')


    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">

                {{ $header ?? '' }}

                <div class="card-body">
                    <div class="table-responsive hoverable-table">

                        {{$dataTable->table()}}

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DATA TABLE JS -->
    <script src="{{ asset('dashboard/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('_dashboard/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>


    {{$dataTable->scripts()}}

    <script>
        $(document).on('click', '.delete-btn', function () {
            let url = $(this).data('url');
            Swal.fire({
                title: "{{ __('messages.Delete Operation') }}",
                text: "{{ __('messages.wont_able_to_revert') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('messages.Delete') }}",
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url,
                        type: 'delete',
                        success(response) {
                            Swal.fire({
                                title: "{{ __('messages.success') }}",
                                text: "{{ __('messages.deleted successfully') }}",
                                type: "success",
                                confirmButtonClass: 'btn btn-success',
                            });
                            $('.dataTable').DataTable().ajax.reload();
                        },
                        error(error) {
                            console.log(error)
                            Swal.fire({
                                type: "error",
                                title: "{{ __('messages.oops') }}",
                                text: "{{ __('messages.something_wrong') }}"
                            });
                        }
                    })
                }
            });
        })

    </script>

    {{ $script ?? '' }}

@stop
