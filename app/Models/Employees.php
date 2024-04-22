<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'identification_number',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getCompanyLogoAttribute()
    {
        return $this->company->logo;
    }
}
