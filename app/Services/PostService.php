<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    private DummyService $service;

    public function __construct(DummyService $service)
    {
        $this->service = $service;
    }

    public function index(): LengthAwarePaginator
    {
        $posts = $this->service->getPosts();

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['id' => $post['id']], // Update condition (e.g., based on the ID)
                [
                    'author_name' => $post['author_name'],
                ]
            );
        }

        return $posts;
    }

    public function getPost(int $id)
    {
        return $this->service->getPost($id);
    }

    public function store(array $data): RedirectResponse
    {
        if (Post::create($data)) {
            return redirect()->back()->with(['msg' => 'Post created!']);
        }
        return redirect()->back()->withErrors(['msg' => 'Post not created!']);
    }

    public function update(array $data, Post $post): RedirectResponse
    {
        if ($post->update($data)) {
            return redirect()->back()->with(['msg' => 'Post updated!']);
        }
        return redirect()->back()->withErrors(['msg' => 'Post not updated!']);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $action = redirect()->route('posts.index');
        $message = ['msg' => 'Post not deleted!'];

        if ($post->delete()) {
            $message = ['msg' => 'Post deleted!'];
            return $action->with($message);
        }

        return $action->withErrors($message);
    }

}
