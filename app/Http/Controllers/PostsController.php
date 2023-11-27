<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\post\StoreRequest;
use App\Http\Requests\post\UpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return [
            [
                'id' => 1,
                'title' => 'Programing',
                'description' => 'This post about programming',
                'body' => 'In 2023 we have a lot of good programming languages, the mos popular are: JavaScript, Php, Golang, Python, Java, C#, C++'
            ],
            [
                'id' => 2,
                'title' => 'University in Almaty',
                'description' => 'This post about universities that located In Almaty',
                'body' => 'If you want to join to universities, firstful you have to think about Almaty'
            ],
            [
                'id' => 3,
                'title' => 'Computers',
                'description' => 'This post about computers',
                'body' => 'Nowadays in companies use DeLL, Lenovo and etc. computers'
            ],
        ];
    }

    public function getAll()
    {
        return Post::get();
    }

    public function getPostById(int $id)
    {
        $post = Post::find($id);
        return $post;
    }

    public function create()
    {
        $postTags = ["Nurkhan", "Abylai", "Islambek"];
        $post = new Post();
        $post->title = 'Users';
        $post->body = 'This post about programmers';
        $post->userId = 2;
        $post->reactions = 20000;
        $post->tags = json_encode($postTags);
        if ($post->save()) {
            return 'good';
        } else {
            return 'bad';
        }
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        if ($data) {
            $post = new Post();
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->userId = $data['userId'];
            $post->reactions = $data['reactions'];
            $post->tags = json_encode(["Nurkhan", "Abylai", "Islambek"]);
            if ($post->save()) {
                return 'good';
            } else {
                return $postCreated->getErrors()->all();
            }
        }
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $updatedPost = $request->validated();

        if ($updatedPost) {
            $tagsAsString = json_encode($updatedPost['tags']);
            $updatedPost['tags'] = $tagsAsString;
            $postUpdated = $post->update($updatedPost);
            if ($postUpdated) {
                return 'success';
            } else {
                return $postUpdated->getErrors()->all();
            }
        }
    }

    public function getPostByTitle(string $title)
    {
        return Post::where('title', "=", $title)->first();
    }
}
