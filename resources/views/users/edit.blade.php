@extends('layouts.app')

@section('content')
@if($errors->any())
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                @foreach($errors->all() as $error)
                <strong>{{$error}}</strong> <br />
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-header">
                    {{__('User')}}
                </div>
                <div class="card-body">
                    <form action="{{ route($item->id ? 'admin.users.update' : 'admin.users.store', ['user'=> $item->id]) }}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if($item->id)
                        <input type="hidden" name="_method" value="PUT" />
                        @endif
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="status" class="form-label">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="null">{{ __('Select') }}</option>
                                    @foreach(App\Models\User::user_statuses() as $status)
                                    <option value="{{$status}}" @if($item->status == $status) selected @endif >{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="email" class="form-label">{{__('Email')}}</label>
                                <input type="text" id="email" class="form-control" name="email" value="{{$item->email}}">
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="form-label">{{__('Name')}}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{$item->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="password" class="form-label">{{__('Password')}}</label>
                                <input type="password" id="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">{{__('Back')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection