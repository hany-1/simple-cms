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
                    {{__('Page')}}
                </div>
                <div class="card-body">
                    <form action="{{ route($item->id ? 'admin.pages.update' : 'admin.pages.store', ['page'=> $item->id]) }}" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @if($item->id)
                        <input type="hidden" name="_method" value="PUT" />
                        @endif
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="title" class="form-label">{{__('Title')}}</label>
                                <input type="text" id="title" class="form-control" name="title" value="{{$item->title}}">
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="form-label">{{__('Name')}}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{$item->name}}">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="null">{{ __('Select') }}</option>
                                    @if(isset($statuses))
                                    @foreach($statuses as $status)
                                    <option value="{{$status}}" @if($item->status == $status) selected @endif >{{ $status }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="parent_id" class="form-label">{{__('Parent')}}</label>
                                <select name="parent_id" id="parent_id" class="form-select">
                                    <option value="{{null}}">{{ __('Select') }}</option>
                                    @if(isset($allPosts))
                                    @foreach($allPosts as $post)
                                    <option value="{{$post->id}}" @if($item->parent_id == $post->id) selected @endif>{{ $post->title }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="menu_order" class="form-label">{{__('Order')}}</label>
                                <input type="number" id="menu_order" class="form-control" name="menu_order" value="{{$item->menu_order}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="checkbox" name="enable_comment" class="form-check-input" id="enable_comment" @if($item->comment_status) checked @endif >
                                <label class="form-check-label" for="enable_comment">{{__('Enable Comment')}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="editor" class="form-label">{{__('Content')}}</label>
                                <textarea id="editor" name="content">{!! $item->content !!}</textarea>
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
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-sm">{{__('Back')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    var editor = new FroalaEditor('#editor', {
        // pluginsEnabled: ['image', 'link', 'draggable'],
    });
</script>
@endsection