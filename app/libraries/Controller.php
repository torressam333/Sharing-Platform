<?php
/*
    *BASE CONTROLLER
    *Loads the models and views
*/
class Controller{

    //Load Model
    public function model($model){
        //require model file
        require_once '../app/models/' . $model . '.php';

        //Instantiate the model
        //return new Model();
        return new $model();
    }

    public function view($view, $data = []){

        //Check for view files
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            //View does not exists
            die('View does not exist!');
        }
    }
}