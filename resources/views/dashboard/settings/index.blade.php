@extends('dashboard.layouts.master')
@section('title', __('messages.Settings') )
@push('styles')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush


@section('content')
    <div class="main-body">
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">


                    <div class="card-body">
                        <form action="{{route('settings.update')}}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @foreach ($settings as $key => $x)
                                <div class="form-group">
                                    @if (App::getLocale() == 'en')
                                        <label class="col-md-3 control-label" for="site_title">{{ $x->title_en }} : </label>
                                    @else
                                        <label class="col-md-3 control-label" for="site_title">{{ $x->title_ar }} : </label>
                                    @endif


                                    @if($x->key_id == 'android_version' || $x->key_id == 'ios_version' || $x->key_id == 'contact_number' )
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="{{ $x->key_id }}" value="@if(isset($x->value)){{$x->value}}@endif">
                                        </div>
                                    @elseif($x->key_id == 'force_update' || $x->key_id == 'force_close')

                                        <div class="col-md-10">
                                            <select   name="{{$x->key_id}}" class="form-control" >
                                                <option @if($x->value  == '1') selected="selected" @endif value="1">{{__('messages.Yes')}}</option>
                                                <option @if($x->value == '0') selected="selected" @endif value="0">{{__('messages.No')}}</option>
                                            </select>
                                        </div>
                                        @else
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="{{ $x->key_id }}" id="site_title">@if(isset($x->value)){{$x->value}}@endif</textarea>
                                            </div>
                                    @endif
                                </div>
                            @endforeach
                            <hr>
                            @can('update settings')
                            <div class="modal-footer">
                                <div class="form-group col-md-12 has-success mg-t-20">
                                    <button type="submit" class="btn btn-success" >{{ __('messages.save') }}</button>
                                </div>
                            </div>
                            @endcan
                </form>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>
    </div>
@endsection
@section('js')

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifit-custom.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('dashboard/js/modal.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote1').summernote({
                height: 300,
                focus: true
            });
            $('#summernote2').summernote({
                height: 300,
                focus: true
            });
        });
    </script>


@endsection
