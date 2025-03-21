<?php

class AdminController extends Controller
{
   public function store($params = [])
   { 
      if(isset($params[0]) && $params[0] == 'user' && isset($params[1])){
         $userId = $params[1];
         $user = User::find($userId);
         $this->view('admin/edit', ['user' => $user]);
      }
   }

   public function update()
   {
      if(isset($_POST['userId'])){
         $userId = $_POST['userId'];
         User::find($userId)->update(['task_description' => $_POST['task_description'], 'status' => (isset($_POST['status']) && $_POST['status'] == 1) ? 1 : 0]);
      }
      return header("location: /home/index");
   }
}