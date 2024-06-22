@extends('dashboard.layouts.master')
@section('title','اضافة عميل')
@section('content')
    <div class="content-body">
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
{{--                        <div class="card-header">--}}
{{--                            <h4 class="card-title">ِيي</h4>--}}
{{--                        </div>--}}
                        <div class="card-content">
                            <div class="card-body">
                                <form id="fileUploadForm" class="needs-validation was-validated" action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row row-sm">
                                        <div class="form-group col-md-6 has-success mg-t-10">
                                            <label for="title_ar">{{ __('Name') }}  :</label>
                                            <input value="{{old('name')}}" id="name" type="text" class="form-control " name="name"  >
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 has-success mg-t-10">
                                            <label for="title_ar">{{ __('messages.phone') }} (The number without the country introduction) :</label>
                                            <input value="{{old('phone')}}" id="phone" type="number" class="form-control " name="phone" required  >
                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>



                                        <div class="modal-footer">
                                            <div class="form-group col-md-12 has-success mg-t-20">
                                                <button type="submit" class="btn btn-success" >{{ __('messages.save') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>

{{--                                {!! Form::open(['route'=>'users.store']) !!}--}}
{{--                                    @include('dashboard.users.form')--}}

{{--                                {!! Form::close() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
