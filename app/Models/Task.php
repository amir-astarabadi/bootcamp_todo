<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 *
 * @property-read \Illuminate\Support\Collection<\App\Models\User> $users
 */
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
