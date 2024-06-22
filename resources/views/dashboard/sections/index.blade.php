
<x-datatable :dataTable="$dataTable" :title="__('messages.section')">
    <x-slot:header>
{{--        @can('create muscles')--}}
            <div class="card-header pb-0">
                <div class="row row-xs wd-xl-80p">
                    <div class="col-sm-6 col-md-3 mg-t-10">
                        <a href="{{route('section.create',$id)}}" class="btn btn-info-gradient btn-block"
                           style="font-weight: bold; color: beige;">{{ __('messages.add') }}
                        </a>
                    </div>
                </div>
            </div>
{{--        @endcan--}}
    </x-slot:header>

    <x-slot:script>
        <script>
            // Function to update the status of the muscle using AJAX
            function updateMuscleStatus(id) {

                $.ajax({
                    url: '{{ route('update-section-status', ":id") }}'.replace(':id', id),
                    type: 'GET', // Use HTTP GET method here
                    success: function(response) {
                        $('#sections-table').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            }

            // Click event handler for the icon
            function st(element) {
                var id = $(element).find('i').data('id');
                // console.log(id);
                updateMuscleStatus(id);
            }
        </script>
    </x-slot:script>

</x-datatable>
