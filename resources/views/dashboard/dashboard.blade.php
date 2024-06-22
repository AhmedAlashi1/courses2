@extends('dashboard.layouts.master')
@section('title', __('messages.Dashboard'))
@push('styles')
    <!--  Owl-carousel css-->
    <link href="{{URL::asset('dashboard/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('dashboard/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="row row-sm">
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{__('messages.Number of users')}}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{\App\Models\User::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{__('Number of Courses')}}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{\App\Models\Courses::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{__('Number of Videos')}}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{(\App\Models\Videos::count()) }}</h4>

                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
{{--        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">--}}
{{--            <div class="card overflow-hidden sales-card bg-warning-gradient">--}}
{{--                <div class="px-3 pt-3  pb-2 pt-0">--}}
{{--                    <div class="">--}}
{{--                        <h6 class="mb-3 tx-12 text-white">PRODUCT SOLD</h6>--}}
{{--                    </div>--}}
{{--                    <div class="pb-0 mt-0">--}}
{{--                        <div class="d-flex">--}}
{{--                            <div class="">--}}
{{--                                <h4 class="tx-20 fw-bold mb-1 text-white">$4,820.50</h4>--}}
{{--                                <p class="mb-0 tx-12 text-white op-7">Compared to last week</p>--}}
{{--                            </div>--}}
{{--                            <span class="float-end my-auto ms-auto">--}}
{{--                                <i class="fas fa-arrow-circle-down text-white"></i>--}}
{{--                                <span class="text-white op-7"> -152.3</span>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>


    <div class="row row-sm">
        <div class=" col-lg-12 col-md-6">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{__('Number of video views')}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! $lineChart->render() !!}
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <!--Internal Sparkline js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('dashboard/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ asset('dashboard/js/index.js') }}"></script>

@stop

