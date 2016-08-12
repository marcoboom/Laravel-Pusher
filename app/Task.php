<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','completed','user_id'];

		protected $casts = ['completed'=>'boolean'];

		protected $appends = ['user_name'];

		public function user()
		{
			return $this->belongsTo(User::class);
		}

		public function getUserNameAttribute()
		{
			return $this->user ? $this->user->name : '-';
		}

}
