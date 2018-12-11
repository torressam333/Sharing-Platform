<?php
class Posts extends Controller{

    public function __construct()
    {
        if(!isLoggedIn()){
            redirect('users/login');
        }

        //Load the model
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index(){
        //Get posts
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts,
        ];

        $this->view('posts/index', $data);
    }

    public function add(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize the post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' => '',
            ];

            //Validate title && check for minimum char count
            if(empty($data['title'])){
                $data['title_error'] = 'Please enter a title for your post';
            }else if(strlen($data['title']) < 5){
                $data['title_error'] = "Hmm, i'm sure you can come up with a more creative title,
                                        why don't you try again? :)";
             }
             //Validate Body && check for minimum char count
             if(empty($data['body'])){
                $data['body_error'] = 'Tsk Tsk, You must enter information in order to submit a post!';
             }else if(strlen($data['body']) < 25){
                $data['body_error'] = "C'mon, you have to have more to share than that. :)";
             }

            //Make sure no errors
            if(empty($data['title_error']) && empty($data['body_error'])){
                //Validated
                if($this->postModel->addPost($data)){
                    flash('post_message', 'Your post has been successfully added to the board.');
                    redirect('posts');
                }else{
                    die('Post not added');
                }

            }else{
                //Load view with errors
                $this->view('posts/add', $data);
            }

        }else{
                    
        $data = [
            'title' => '',
            'body' => '',
        ];

        $this->view('posts/add', $data);
        }
    }

    public function edit($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize the post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' => '',
            ];

            //Validate title && check for minimum char count
            if(empty($data['title'])){
                $data['title_error'] = 'Please enter a title for your post';
            }else if(strlen($data['title']) < 5){
                $data['title_error'] = "Hmm, i'm sure you can come up with a more creative title,
                                        why don't you try again? :)";
             }
             //Validate Body && check for minimum char count
             if(empty($data['body'])){
                $data['body_error'] = 'Tsk Tsk, You must enter information in order to submit a post!';
             }else if(strlen($data['body']) < 25){
                $data['body_error'] = "C'mon, you have to have more to share than that. :)";
             }

            //Make sure no errors
            if(empty($data['title_error']) && empty($data['body_error'])){
                //Validated
                if($this->postModel->updatePost($data)){
                    flash('post_message', 'Your post has been successfully updated.');
                    redirect('posts');
                }else{
                    die('Post not added');
                }

            }else{
                //Load view with errors
                $this->view('posts/edit', $data);
            }

        }else{
            
            //Fetch current post from model
            $post = $this->postModel->getPostById($id);

            //Check for owner of post
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
                    
        $data = [
            'id' => $id,
            'title' => $post->title,
            'body' => $post->body,
        ];

        $this->view('posts/edit', $data);
        }
    }

    public function show($id){
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user,
        ];

        $this->view('posts/show', $data);
    }

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get existing post from model
          $post = $this->postModel->getPostById($id);
          
          // Check for owner
          if($post->user_id != $_SESSION['user_id']){
            redirect('posts');
          }
  
          if($this->postModel->deletePost($id)){
            flash('post_message', 'Post Removed');
            redirect('posts');
          } else {
            die('Something went wrong');
          }
        } else {
          redirect('posts');
        }
      }
}