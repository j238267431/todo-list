<?php

class TaskController extends Controller
{
   protected $task;

   public function __construct()
   {
      $this->task = $this->model('Task');
   }

   public function index()
   {
      // var_dump($_SESSION);
      if(isset($_SESSION['user']) && $_SESSION['user']['id'] != '' ){
         $userId = $_SESSION['user']['id'];
         $isAdmin = false;

         if(isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']){
            $isAdmin = true;
            $tasks = Task::all();
         } else {
            $tasks = Task::where('user_id', '=', $userId)->get();
         }
         
         $this->view('/task/index', ['tasks' => $tasks, 'isAdmin' => $isAdmin]);
      }   
   }

   public function store()
   {
      $users = User::all();
      $this->view('/task/create', ['users' => $users]);
   }

   public function create($request)
   {

      try {
         @$user = User::find($request['user']);
         $task = $user->tasks()->create([
            'name' => $request['task_name'],
            'description' => $request['task_description'],
         ]);
         
         $tasks = Task::all();
         $isAdmin = false;
         if(isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']){
            $isAdmin = true;
         }
         if($task){
            $this->view('/task/index', ['successText' => 'Задача успешно создана', 'tasks' => $tasks, 'isAdmin' => $isAdmin]);
         } else {
            $this->view('/task/index', ['errorText' => 'Задача не создана', 'tasks' => $tasks, 'isAdmin' => $isAdmin ]);
         }
      // } catch (\Illuminate\Database\QueryException $exception) {
      } catch(\Throwable $exception) {
         $errorInfo = $exception->getMessage();
         // var_dump($errorInfo);
         $this->view('/home/index', ['errorText' => $errorInfo]);
      }
   }
   public function updateStatus($request)
   {
      try {
         $task = Task::find($request['taskId']);
         $status = $request['status'];
         $task->update([
            'status' => $status
         ]);
      } catch (\Throwable $exception) {
         $errorInfo = $exception->getMessage();
         // var_dump($errorInfo);
         $this->view('/home/index', ['errorText' => $errorInfo]);
      }
   }
}