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
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
