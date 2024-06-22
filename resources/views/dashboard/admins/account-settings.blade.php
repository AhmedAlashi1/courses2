
@extends('dashboard.layouts.master')
@section('title', 'Account settings')

@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <form id="fileUploadForm" class="needs-validation was-validated" action="{{route('Admin.updateAccountSettings')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="name">{{ __('messages.Name') }}  :</label>
                                <input value="{{$admin->name}}" id="name" type="text" class="form-control " name="name"  required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="email">{{ __('messages.email') }}  :</label>
                                <input value="{{$admin->email}}" id="name_en" type="email" class="form-control " name="email"  required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="password">{{ __('messages.password') }}  :</label>
                                <input id="password" type="password" class="form-control " name="password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 has-success mg-t-10">
                                <label for="password_confirmation">{{ __('messages.password confirmation') }}  :</label>
                                <input id="password_confirmation" type="password" class="form-control " name="password_confirmation">
                            </div>

                            <div class="modal-footer">
                                <div class="form-group col-md-12 has-success mg-t-20">
                                    <button type="submit" class="btn btn-success" >{{ __('messages.save') }}</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-green"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 0%; background-color: green">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

