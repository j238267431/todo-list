<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
   public $name;

   protected $fillable = ['name', 'description', 'status', 'user_id'];

   public function user()
   {
      $this->hasOne(User::class);
   }

}