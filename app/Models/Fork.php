<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fork extends Model
{
    //
    use SoftDeletes;

    const CLONED = 1;
    const PENDING = 2;
    const NO_CLONE = 0;

    protected $fillable = [
        'user_id',
        'repo_name',
        'html_url',
        'status',
        'owner',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
