<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use Soft Deletes */
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_id',
    ];

    protected $table = 'companies';

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company_employee()
    {
        return $this->hasMany(CompanyEmployees::class, 'company_id', 'id');
    }
}
