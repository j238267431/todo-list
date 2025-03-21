<?php

class Controller
{
   public function model($model)
   {
      require_once '../app/models/'.$model.'.php';
      return new $model();
   }

   public function view($view, $data = [])
   
   {
      $loader = new \Twig\Loader\FilesystemLoader('../app/views/');
      $twig = new \Twig\Environment($loader);
      $twig->addGlobal('session', $_SESSION);

      echo $twig->render($view.'.twig', $data);
   }
}