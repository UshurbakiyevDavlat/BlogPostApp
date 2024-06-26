@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Редактирование поста') }}</div>

                    <div class="card-body">
                        @if(session('msg'))
                            <div class="alert alert-success">
                                {{ session('msg') }}
                            </div>
                        @elseif ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('posts.update', $post['id']) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title"><b>Title</b></label>
                                <input required type="text" class="form-control" id="title" name="title" value="{{ $postDummy['title'] }}">
                            </div>

                            <div class="form-group">
                                <label for="body"><b>Body</b></label>
                                <textarea required class="form-control" id="body" name="body" rows="3">{{ $postDummy['body'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="author_name"><b>AuthorName</b></label>
                                <textarea required class="form-control" id="author_name" name="author_name" rows="3">{{ $post['author_name'] }}</textarea>
                            </div>

                            <button type="submit" class="btn mt-4 btn-primary">Save</button>
                            <a style="margin-left: 10px" href="{{route('posts.index')}}" class="btn mt-4 btn-primary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
