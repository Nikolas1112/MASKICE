<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'password', 'group',
        'additional_roles', 'is_active', 'city', 'address', 'oib',
        'agreement_start_date', 'agreement_end_date', 'agreement_file',
        'net_salary', 'gross_salary', 'bonus', 'additional_message', 'warehouse'
    ];

    protected $casts = [
        'additional_roles' => 'array',
        'is_active' => 'boolean',
        'agreement_start_date' => 'date',
        'agreement_end_date' => 'date',
    ];

    public function getIsActiveAttribute()
    {
        return $this->attributes['is_active'] == 1;
    }

}
