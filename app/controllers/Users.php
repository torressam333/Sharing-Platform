<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register(){
        //Check for Post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process the form

            //Sanitize the POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
              //Init data
        $data =[
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'name_error' => '',
            'email_error' => '',
            'password_error' => '',
            'confirm_password_error' => ''
        ];

        //Form validation:

        //email
        if(empty($data['email'])){
            $data['email_error'] = 'Please enter your email address.';
        }else{
            //Check email
            if($this->userModel->findUserByEmail($data['email'])){
                $data['email_error'] = 'Email address is already taken';
            }
        }
        //Name
        if(empty($data['name'])){
            $data['name_error'] = 'Please enter your name.';
        }
        //Password
        if(empty($data['password'])){
            $data['password_error'] = 'Please enter your Password.';
        }elseif(strlen($data['password']) < 6){
            $data['password_error'] = 'Your password must be at least 6 characters';
        }

         //Validate Confirm password
         if(empty($data['confirm_password'])){
            $data['confirm_password_error'] = 'Please confirm your password.';
        }else{
            if($data['password'] != $data['confirm_password']){
                $data['confirm_password_error'] = 'Passwords do not match. Double check and try again';
            }
        }

        //Make sure no errors are empty
        if(empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) 
        && empty($data['confirm_password_error']))
        {
            //Validated
            //HASH the password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            //Register user (call a model function)
            if($this->userModel->register($data)){
               flash('register_success', 'You are registered and may now login');
               redirect('users/login');
            }else{
                die('SOMETHING WENT WRONG');
            }
        }else{
            //Load view with errors
            $this->view('users/register', $data);
        }
        }else{
        //Init data
        $data =[
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'name_error' => '',
            'email_error' => '',
            'password_error' => '',
            'confirm_password_error' => ''
        ];

        //Load the view
        $this->view('users/register', $data);
        
    }
  }
  public function login(){
    //Check for Post
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Process the form
          //Sanitize the POST data
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          //Init data
            $data =[
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'email_error' => '',
            'password_error' => '',
            ];

        // Validate Email
        if(empty($data['email'])){
            $data['email_error'] = 'Pleae enter email';
          }
  
          // Validate Password
          if(empty($data['password'])){
            $data['password_error'] = 'Please enter password';
          }

            // Check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                // User found
            } else {
                // User not found
                $data['email_error'] = 'No user found';
            }

          // Make sure errors are empty
          if(empty($data['email_error']) && empty($data['password_error'])){
            // Validated

            //Check and set logged in user
            $loggedInUser = $this->userModel->login($data['email'], $data['password']);

            if($loggedInUser){
                //Create session
                $this->createUserSession($loggedInUser);
            }else{
                $data['password_error'] = 'Password is incorrect';

                //Load View
                $this->view('users/login', $data);
            }
          } else {
            // Load view with errors
            $this->view('users/login', $data);
          }
  
        } else {
          // Init data
          $data =[    
            'email' => '',
            'password' => '',
            'email_error' => '',
            'password_error' => '',        
          ];
  
          // Load view
          $this->view('users/login', $data);
        }
      }

      public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['name'] = $user->name;
        //Redirect to post controller
        redirect('posts');
      }

      public function logout(){
        unset( $_SESSION['user_id']);
        unset( $_SESSION['email']);
        unset( $_SESSION['name']);
        session_destroy();
        redirect('users/login');
      }

    
    }