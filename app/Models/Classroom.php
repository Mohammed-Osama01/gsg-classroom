<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Observers\ClassroomObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    public static string $disk = 'public';

    protected $fillable = [
        'name', 'section', 'subject', 'room', 'theme', 'cover_image_path', 'code','user_id'
    ];
    protected $appends = [
        'cover_image_url',
        'user_name',
    ];

    protected $hidden = [
        'cover_image_patj',
        'deleted_at',
    ];


    function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class, 'classroom_id', 'id');   //''foreign_Key  primaryKey
    }

    function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'classroom_id', 'id');   //''foreign_Key  primaryKey
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(
        User::class,        //Related Model
        'classroom_user',   //Pivot table
        'classroom_id',     //FK for current model in the pivot table
        'user_id',          // //FK for related model in the pivot table
        'id',               //pk for current model
        'id',               //pk for related model
    )->withPivot(['role', 'created_at']);
    }

    public function teachers()
    {
        return $this->users()->wherePivot('role', '=','teacher');
    }
    public function students()
    {
        return $this->users()->wherePivot('role', '=','student');
    }
    public function streams()
    {
        return $this->hasMany(Stream::class)->latest();
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public static function uploadCoverImage($file)
    {
        $path = $file->store('/covers', [
            'disk' => 'public'
        ]);
        return $path;
    }
    public static function deleteCoverImage($path)
    {
        if ($path && Storage::disk(Classroom::$disk)->exists($path));
        return Storage::disk(Classroom::$disk)->delete($path);
    }

    //local scope
    public function scopeActive(Builder $query)
    {
        $query->where('status', '=', 'active');
    }

    public function scopeRecent(Builder $query)
    {
        $query->orderBy('updated_at', 'Desc');
    }

    public function scopeStatus(Builder $query, $status = 'active')
    {
        $query->where('status', '=', $status);
    }



    public function join($user_id, $role = 'student')
    {

        return $this->users()->attach($user_id , [
            'role' => $role,
            'created_at'=>now(),
        ]);   //INSERT

        // return  DB::table('classroom_user')->insert([
        //     'classroom_id' => $this->id,
        //     'user_id' => $user_id,
        //     'role' => $role,
        //     'created_at' => now()
        // ]);
    }
}
