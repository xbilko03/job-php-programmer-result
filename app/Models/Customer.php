<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	use HasFactory;
	public $table = 'customers';
	public function groups()
	{
		return $this->belongsToMany(Group::class, 'customer_group_relation', 'customer_id', 'groups_id');
	}
}
