<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function classrooms()
    {

        return $this->belongsToMany(
            Classroom::class,        // Related model
            'classroom_user',       // Pivot table
            'user_id',              // FK for current model in the pivot table
            'classroom_id',         // FK for related model in pivot table
            'id',                  // PK for current mode
            'id'                   // PK for related model
        )->withPivot(['role', 'created_at']);
    }

    public function createdClassrooms()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }

    public function classwork()
    {
        return $this->belongsToMany('Classwork::claas')
        ->using(ClassworkUser::class)
        ->withPivot(['grade','status','submitted_at','created_at']);
    }


    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class,'user_id','id')
        ->withDefault();
    }

}
