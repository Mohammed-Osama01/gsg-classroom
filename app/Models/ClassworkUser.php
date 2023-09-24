<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassworkUser extends Model
{
    use HasFactory;

    public function getUpdatedAtColumn()
    {
    }
    /**
     * Summary of setUpdatedAt
     * @param mixed $value
     * @return static
     */
    public function setUpdatedAt($value)
    {
        return $this;
    }

}
