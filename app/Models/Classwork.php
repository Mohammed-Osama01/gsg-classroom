<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classwork extends Model
{
    use HasFactory;

    protected $morphClass = 'App\Models\Classwork';

    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_MATERIAL = 'material';
    const TYPE_QUESTION = 'question';

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';

    protected $fillable = [
        'classroom_id', 'user_id', 'topic_id', 'title',
        'description', 'type', 'status', 'published_at', 'options'
    ];

    protected $casts = [
        'options' => 'json',
        'published_at' => 'date'
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['grade', 'submitted_at', 'status', 'created_at'])
            ->using(ClassworkUser::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }


    /**
     * @return mixed
     */
    public function getMorphClass()
    {
        return $this->morphClass;
    }

    /**
     * @param mixed $morphClass
     * @return self
     */
    public function setMorphClass($morphClass): self
    {
        $this->morphClass = $morphClass;
        return $this;
    }
}
