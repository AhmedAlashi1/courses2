
<x-datatable :dataTable="$dataTable" :title="__('Buy Course')">

    <x-slot:header>
        {{--        @can('create muscles')--}}
        <div class="card-header pb-0">
            <div class="row row-xs wd-xl-80p">
                <div class="col-sm-6 col-md-3 mg-t-10">
                    <a href="{{route('buy_course_user.create',$id)}}" class="btn btn-info-gradient btn-block"
                       style="font-weight: bold; color: beige;">{{ __('messages.add') }}
                    </a>
                </div>
            </div>
        </div>
        {{--        @endcan--}}

        <div class="card-header pb-0">
            <div class="row row-xs wd-xl-80p">
                <div class="col-sm-6 col-md-6 mg-t-10">
                    <p  class="form-label" style=" color: #333;   font-size: 16px;">{{__('User Name')}} : {{$user->name}}</p>
                </div>
                <div class="col-sm-6 col-md-6 mg-t-10">
                    <p  class="form-label" style=" color: #333;   font-size: 16px;">{{__('Phone')}} : {{$user->phone}}</p>
                </div>
        </div>
        </div>
    </x-slot:header>
    <x-slot:script>
        <script>
            // Function to update the status of the muscle using AJAX
            function updateMuscleStatus(id) {

                $.ajax({
                    url: '{{ route('update-buy_course_user-status', ":id") }}'.replace(':id', id),
                    type: 'GET', // Use HTTP GET method here
                    success: function(response) {
                        $('#buy_course_user-table').DataTable().ajax.reload();
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

