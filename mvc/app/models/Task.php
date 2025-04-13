<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
   public $name;

   protected $fillable = ['name', 'description', 'stage_id', 'user_id'];

   public function user()
   {
      $this->hasOne(User::class);
   }

   public function stage()
   {
      $this->hasOne(Stage::class);
   }

}