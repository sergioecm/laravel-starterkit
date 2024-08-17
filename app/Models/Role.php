<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

//    /**
//     * The users that belong to the role.
//     */
//    public function users(): BelongsToMany
//    {
//        return $this->belongsToMany(User::class)->using(RoleUser::class);
//    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }


}
