<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //define Gates (abilties)
        // Gate::define('classworks.view',function(User $user , Classwork $classwork){
        //     $teacher =  $user->classrooms()
        //     ->wherePivot('classroom_id', '=' , $classwork->classroom_id)
        //     ->wherePivot('role', '=', 'teacher')
        //     ->exists();

        //     $assigned = $user->classworks()
        //     ->wherePivot('classwork')
        // });

        // Gate::define('classworks.create',function(User $user , Classroom $classroom){
        //     return $user->classrooms()
        //     ->wherePivot('classroom_id', '=' , $classroom->id)
        //     ->wherePivot('role', '=', 'teacher')
        //     ->exists();
        // });
        // Gate::define('classworks.update',function(User $user , Classroom $classroom){
        //     return $user->classrooms()
        //     ->wherePivot('classroom_id', '=' , $classroom->id)
        //     ->wherePivot('role', '=', 'teacher')
        //     ->exists();
        // });
        // Gate::define('classworks.delete',function(User $user , Classroom $classroom){
        //     return $user->classrooms()
        //     ->wherePivot('classroom_id', '=' , $classroom->id)
        //     ->wherePivot('role', '=', 'teacher')
        //     ->exists();
        // });
    }
}
