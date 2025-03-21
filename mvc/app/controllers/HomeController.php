<?php

class HomeController extends Controller
{
   protected $user;
   protected $sortByField = 'username';
   protected $sortOrder = 'asc';
   protected $isAdmin = false;

   public function __construct()
   {
      $this->user = $this->model('User');
      (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) ? $this->isAdmin = true : $this->isAdmin = false;
   }
   
   public function index($params = [])
   {
      if(isset($_SESSION['user']) ){
         $this->view('home/index', ['user' => $_SESSION['user']]);
         die;
      } else {
         $this->view('auth/auth');
      }
      // if(isset($params[0]) && $params[0] == 'sort'){
      //    if(isset($params[1])){
      //       $this->sortByField = $params[1];
      //       if(isset($params[2])){
      //          $this->sortOrder = $params[2]; 
      //       }
            
      //    }
         
      // }
      // $users = User::orderBy($this->sortByField, $this->sortOrder)->get();

      // $this->view('home/index', ['users' => $users, 'isAdmin' => $this->isAdmin]);
      // $tasks = Task::all();
      // $this->view('home/index', ['tasks' => $tasks, 'isAdmin' => $this->isAdmin]);
   }
}