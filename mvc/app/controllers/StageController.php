<?php

use App\Traits\FlashMessages;

class StageController extends Controller
{
   use FlashMessages;
   protected $stage;

   public function __construct()
   {
      $this->stage = $this->model('Stage');
   }

   public function store()
   {
      $users = User::all();
      $this->view('/stage/create', ['users' => $users]);
   }

   public function create($request)
   {

      try {
         $stagesCount = Stage::count();
         $stage = Stage::create([
            'name' => $request['stage_name'],
            'order' => $stagesCount + 1
         ]);
         $stages = Stage::orderBy('order', 'ASC')->get();
         $tasks = Task::all();
         $isAdmin = false;
         if(isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']){
            $isAdmin = true;
         }
         if($stage){
            $this->flash(['success' => 'Стадия успешно создана']);
            header('Location: '.$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].'/task/index');
         } else {
            $this->flash(['error' =>'Стадия не создана']);
            header('Location: '.$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].'/task/index');
         }
      // } catch (\Illuminate\Database\QueryException $exception) {
      } catch(\Throwable $exception) {
         $errorInfo = $exception->getMessage();
         // var_dump($errorInfo);
         $this->view('/home/index', ['errorText' => $errorInfo]);
      }
   }

   public function changeOrder($request)
   {
      $newOrder = json_decode($request['newOrder']);
      foreach($newOrder as $k => $id){
         $stage = Stage::find($id);
         $stage->update([
            'order' => $k
         ]);
      }

      
   }
}