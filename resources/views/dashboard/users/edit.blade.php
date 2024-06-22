@extends('dashboard.layout.main')
@section('title','تعديل عميل')
@section('content')
    <div class="content-body">
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">تعديل عميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <a  href="{{route('admin.users.index')}}" class="btn btn-primary mb-2 waves-effect waves-light">&nbsp; كل العملاء </a>
                                {!! Form::model($user,['route'=>['admin.users.update',$user],'method'=>'PUT']) !!}
                                @include('dashboard.users.form')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
