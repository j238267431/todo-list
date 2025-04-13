<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Stage extends Eloquent
{
   public $name;

   protected $fillable = ['name', 'order'];

   public function task()
   {
      $this->hasMany(Task::class);
   }

}