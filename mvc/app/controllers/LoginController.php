<?php

use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
   public function index()
   {
      $this->view('auth/auth');
   }



   public function login()
   {
      if(isset($_POST['name']) && $_POST['name'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
         try {
            $user = User::where('username', '=', $_POST['name'])->first();
            if(is_null($user)){
               $this->view('/auth/auth', ['errorText' => 'Пользователь с такими данными не зарегистрирован']);
               die;
            } else {
               if(password_verify($_POST['password'], $user['password'])){
                  $_SESSION['user'] = $user;
                  if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                     $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                     $user::update([
                        'password' => $newHash,
                     ]);
                 }
                  header('Location: /home/index');
               } else {
                  // $this->view('/auth/auth', ['errorText' => 'Неверный пользователь или пароль']);
                  die;
               }
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            $this->view('/reg/reg', ['errorText' => $errorInfo]);
        }
      } 
      $this->view('/auth/auth', [
         'errorText' => 'Неверный логин или пароль',
         'userName' => $_POST['name'],
         'password' => ''
      ]);
      die;

   }
   public function logOut()
   {
      session_destroy();
      header('Location: /home/index');
   }

   private function isAdmin($name, $password)
   {
      if($name == 'admin' && $password == '123'){
         return true;
      }
      return false;
   }
}