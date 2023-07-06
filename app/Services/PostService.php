<?php

namespace App\Services;

use App\Models\Post;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

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

        foreach ($posts as $key => $post) {
            $existingPost = Post::withTrashed()->find($post['id']);
            if ($existingPost && $existingPost->deleted_at !== null) {
                $posts->forget($key);
            }
        }

        return $posts;
    }

    public function getPost(int $id)
    {
        return $this->service->getPost($id);
    }

    /**
     * @throws Exception
     */
    public function store(array $data): RedirectResponse
    {
        $dummy = $this->dummyAddPost($data);
        unset($data['title'], $data['body']);

        if ($dummy && Post::create($data)) {
            return redirect()->route('posts.index')->with(['msg' => 'Post created!']);
        }
        return redirect()->back()->withErrors(['msg' => 'Post not created!']);
    }

    public function update(array $data, Post $post): RedirectResponse
    {
        $dummy = $this->dummyUpdatePost($data);

        unset($data['title'], $data['body']);

        if ($dummy && $post->update($data)) {
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

    private function dummyAddPost($data): string|RedirectResponse
    {
        $dummyData['title'] = $data['title'];
        $dummyData['body'] = $data['body'];
        $dummyData['userId'] = random_int(1, 100);

        try {
            $result = $this->service->addPost($dummyData);
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['msg' => 'Post not updated!']);
        }

        return $result;
    }

    private function dummyUpdatePost($data): string|RedirectResponse
    {
        $dummyData['title'] = $data['title'];
        $dummyData['body'] = $data['body'];

        try {
            $result = $this->service->updatePost($dummyData);
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['msg' => 'Post not updated!']);
        }
        return $result;
    }
}
