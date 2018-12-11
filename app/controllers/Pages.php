<?php
class Pages extends Controller
{  
    public function __construct()
    {

    }

    public function index()
    {
        if(isLoggedIn()){
            redirect('posts');
        }
        $data = [
            'title' => 'SharePosts',
            'description' => 'Interactive social network built on the TorresMVC PHP framework.'
    ];

        $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'An application to share your thoughts and ideas with other users!'
    ];
        $this->view('pages/about', $data);
    }
}