<?php
namespace src\controllers;

use src\core\view;
use src\models\post;

class blogcontroller
{
    private post $postmodel;
    
    public function __construct()
    {
        $this->postmodel = new post();
    }

    public function index()
    {
        $posts = $this->postmodel->getallposts();
        view::render('blog', ['posts' => $posts, 'title' => 'Blog']);
    }

    public function show(string $slug)
    {
        $post = $this->postmodel->getpostbyslug($slug);

        if (!$post)
        {
            http_response_code(404);
            die("404 - Post Not Found");
        }

        view::render('single', ['post' => $post, 'title' => $post['title']]);
    }
}

?>