<?php

use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
   public function index()
   {
      $this->view('reg/reg');
   }

   public function register()
   {

      if(isset($_POST['name']) && $_POST['name'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
         $user = User::where('username', '=', $_POST['name'])->first();
         if(!is_null($user)){
            $this->view('/reg/reg', [
               'errorText' => 'Пользователь с таким именем уже зарегистрирован',
               'userName' => $_POST['name'],
               'password' => ''
            ]);
         } else {

            try {

               $user = User::create(
                  [
                     'username' => $_POST['name'],
                     'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                  ]
               );
               if(!is_null($user)){
                  $_SESSION['user'] = $user;
                  header('Location: /home/index');
               }
           } catch (\Illuminate\Database\QueryException $exception) {

               $errorInfo = $exception->errorInfo;
               echo '<pre>';
               var_dump($errorInfo);
               $this->view('/reg/reg', ['errorText' => $errorInfo]);
           }
         }
      } 
      $this->view('/reg/reg', [
         'errorText' => 'не указан логин и/или пароль',
         'userName' => $_POST['name'],
         'password' => ''
      ]);

   }
}