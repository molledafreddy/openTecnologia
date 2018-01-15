<?php

namespace App;
use App\Employee;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name', 'city_id',
    ];

    public function employees()
    {
    	 return $this->HasMany(Employee::class);
    }
}
