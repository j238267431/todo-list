<?php
use App\Traits\FlashMessages;
class TaskController extends Controller
{
   use FlashMessages;
   protected $task;
   protected $stage;

   public function __construct()
   {
      $this->task = $this->model('Task');
      $this->stage = $this->model('stage');
   }

   public function index()
   {

      $message = $this->flash();
      
      if(isset($_SESSION['user']) && $_SESSION['user']['id'] != '' ){
         $userId = $_SESSION['user']['id'];
         $isAdmin = false;
         $stages = Stage::orderBy('order', 'ASC')->get();
         if(isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']){
            $isAdmin = true;
            $tasks = Task::all();
         } else {
            $tasks = Task::where('user_id', '=', $userId)->get();
         }
         
         $this->view('/task/index', ['tasks' => $tasks, 'isAdmin' => $isAdmin, 'stages' => $stages, 'message' => $message]);
      }   
   }

   public function store()
   {
      $users = User::all();
      $stages = Stage::all();
      $this->view('/task/create', ['users' => $users, 'stages' => $stages]);
   }

   public function create($request)
   {

      try {
         @$user = User::find($request['user']);
         $task = $user->tasks()->create([
            'name' => $request['task_name'],
            'description' => $request['task_description'],
            'stage_id' => $request['stage'],
         ]);
         
         $tasks = Task::all();
         $isAdmin = false;
         if(isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']){
            $isAdmin = true;
         }
         $stages = Stage::orderBy('order', 'ASC')->get();
         if($task){
            $this->flash(['success' => 'Задача успешно создана']);
            header('Location: '.$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].'/task/index');
         } else {
            $this->flash(['error' =>'Задача не создана']);
            header('Location: '.$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].'/task/index');
         }
      // } catch (\Illuminate\Database\QueryException $exception) {
      } catch(\Throwable $exception) {
         $errorInfo = $exception->getMessage();
         $this->view('/home/index', ['errorText' => $errorInfo]);
      }
   }
   public function updateStatus($request)
   {
      try {
         $task = Task::find($request['taskId']);
         $status = $request['status'];
         $task->update([
            'stage_id' => $status // ToDo
         ]);
      } catch (\Throwable $exception) {
         $errorInfo = $exception->getMessage();
         $this->view('/home/index', ['errorText' => $errorInfo]);
      }
   }
}