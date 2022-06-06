<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    	use HasFactory;
	public $table = 'groups';
	public function groups()
	{
		return $this->belongsToMany(Customer::class, 'customer_group_relation', 'customer_id', 'groups_id');
	}
}
