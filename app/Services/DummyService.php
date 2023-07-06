<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class DummyService
{
    private Response $postConnection;
    private Response $usersConnection;

    public function connect(): void
    {
        $this->postConnection = Http::get('https://dummyjson.com/posts?limit=150');
        $this->usersConnection = Http::get('https://dummyjson.com/users');
    }

    public function getPosts(): LengthAwarePaginator
    {
        $this->connect();

        $users = $this->usersConnection->json()['users'];
        $posts = $this->postConnection->json()['posts'];

        $posts = collect($posts)->map(static function ($post) use ($users) {
            $author = collect($users)->firstWhere('id', $post['userId']);

            $post['author_name'] = $author ? $author['firstName'] . ' ' . $author['lastName'] : '';

            return $post;
        });

        $perPage = 30;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $posts->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $posts = new LengthAwarePaginator($pagedData, $posts->count(), $perPage, $currentPage);
        $posts->withPath(Request::url());

        return $posts;
    }

    public function getPost(int $id)
    {
        $this->connect();

        $posts = $this->postConnection->json()['posts'];

        return collect($posts)->firstWhere('id', $id);
    }
}
