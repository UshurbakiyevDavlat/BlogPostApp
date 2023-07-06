@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Посты') }}
                        <span class="float-end">
                            <a class="btn btn-sm btn-info position-relative" href="{{ route('posts.create') }}">Создать</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(session('msg'))
                                <div class="alert alert-success">
                                    {{ session('msg') }}
                                </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post['id'] }}</td>
                                    <td>{{ $post['title'] }}</td>
                                    <td>{{ $post['body'] }}</td>
                                    <td>
                                        <a href="{{ route('posts.edit', $post['id']) }}" class="btn btn-sm btn-primary mb-1">Редактировать</a>
                                        <form action="{{ route('posts.destroy', $post['id']) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
