<?php

namespace App\Traits;

trait FlashMessages 
{
   function flash(?array $message = null)
   {
      // var_dump($message);
       if ($message) {
           $_SESSION['flash'] = $message;
       } else {
         if(isset($_SESSION['flash'])){
            $message = $_SESSION['flash'];
            unset($_SESSION['flash']);
            if (!empty($message)) { 
            return $message;
            }
         }
         
           
       }
   }
}