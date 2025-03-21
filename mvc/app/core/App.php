<?php

class App
{

   protected $controller = 'home';
   
   protected $method = 'index';

   protected $params = [];

   protected $actionIsAllowed = true;

   protected $restrictions = [
      'TaskController' => [
         'methods' => [
            'store',
            'create'
         ]
      ],
   ];

   public function __construct()
   {
      $url = $this->parseUrl();
      unset($url[0]);
      if (file_exists('../app/controllers/' . ucwords($url[1]) . 'Controller.php')) 
      {
         // var_dump('../app/controllers/' . $this->controller . 'Controller.php');
         $this->controller = ucwords($url[1]);
         unset($url[1]);
      }
      
      require_once '../app/controllers/' . $this->controller . 'Controller.php';
      $controller = $this->controller . 'Controller';
      $this->controller = new $controller;

      if(isset($url[2]))
      {
         if(method_exists($this->controller, $url[2]))
         {
            $this->method = $url[2];
            unset($url[2]);
         }
      }

      $this->params = $url ? array_values($url) : [];
      count($this->params) == 0 ? $this->params = $_REQUEST : [];
      // var_dump($_SESSION);


      $controllerHasRestrictions = isset($this->restrictions[get_class($this->controller)]);

      if($controllerHasRestrictions){
         $methodHasRestrictions = in_array($this->method, $this->restrictions[get_class($this->controller)]['methods']);
      }
      if( $controllerHasRestrictions && $methodHasRestrictions ) {
         $this->checkRestrictions();
      }

      if($this->actionIsAllowed){
         call_user_func_array([$this->controller, $this->method], [$this->params]);
      } else {
         header('location: /home/index');
         $_SESSION['flash'] = 'не разрешенный путь';
      }


   }

   protected function checkRestrictions(){
      $this->actionIsAllowed = false;
      if(isset($_SESSION['user']) && $_SESSION['user']['is_admin']){
         $this->actionIsAllowed = true;
      }
      
      
   }

   public function parseUrl()
   {
      // echo($_GET['url']);
      if(isset($_GET['url']))
      {
         return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
      }
   }
}