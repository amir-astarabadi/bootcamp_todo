<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'board_id',
        'creator_id',
    ];

    public function creator()
    {
        return $this->BelongsTo(User::class);
    }

    public function board()
    {
        return $this->BelongsTo(Board::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
