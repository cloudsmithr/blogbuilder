<?php

namespace src\controllers;
use src\core\view;

class maincontroller
{
    public function index()
    {
        view::render('home', ['title' => 'Welcome to My Site']);
    }

    public function about()
    {
        view::render('about', ['title' => 'About Us']);
    }
}