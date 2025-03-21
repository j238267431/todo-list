<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
      'driver' => 'mysql',
      'host' => 'mysql',
      'username' => 'root',
      'password' => 'root',
      'database' => 'to_do_list',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => ''
   ]);

   $capsule->bootEloquent();
