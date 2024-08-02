<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Profile
 *
 * @property int $user_id
 * @property string $company
 * @property string $nationality
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $owner
 */
class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'nationality',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function image2()
    {
        return $this->hasOne(Image::class);
    }
}
