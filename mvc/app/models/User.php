<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Eloquent
{
   public $name;

   protected $fillable = ['username', 'password', 'created_at', 'updated_at', 'is_admin'];
   public $timestamps = false;

   public function tasks(): HasMany
   {
      return $this->hasMany(Task::class);
      // доделать как здесь https://stackoverflow.com/questions/73701808/how-to-use-the-relationship-with-belongstomany-in-eloquent
   }
}

