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
                    {{__('Tag')}}
                </div>
                <div class="card-body">
                    <form action="{{ route($item->id ? 'admin.tags.update' : 'admin.tags.store', ['tag'=> $item->id]) }}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if($item->id)
                        <input type="hidden" name="_method" value="PUT" />
                        @endif
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="name" class="form-label">{{__('Name')}}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{$item->name}}">
                            </div>
                            <div class="col-md-4">
                                <label for="slug" class="form-label">{{__('Slug')}}</label>
                                <input type="text" id="slug" class="form-control" name="slug" value="{{$item->slug}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="description" class="form-label">{{__('Description')}}</label>
                                <textarea id="description" class="form-control" name="description">{!! ($item->taxanomy ? $item->taxanomy->description : null) !!}</textarea>
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
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-primary btn-sm">{{__('Back')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection