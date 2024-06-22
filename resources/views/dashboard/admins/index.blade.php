
<x-datatable :dataTable="$dataTable" :title="__('messages.Admin')">
    <x-slot:header>
{{--        @can('create admins')--}}
            <div class="card-header pb-0">
                <div class="row row-xs wd-xl-80p">
                    <div class="col-sm-6 col-md-3 mg-t-10">
                        <a href="{{route('admins.create')}}" class="btn btn-info-gradient btn-block"
                           style="font-weight: bold; color: beige;">{{ __('messages.add') }}
                        </a>
                    </div>
                </div>
            </div>
{{--        @endcan--}}
    </x-slot:header>
</x-datatable>
