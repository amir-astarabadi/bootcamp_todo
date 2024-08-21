<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\User\PlanAuthorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use PlanAuthorization;

    // scope
    // relations
    // accessor
    // mutators

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

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'creator_id');
    }

    public function createBoard(array $data): Board
    {
        return $this->boards()->create($data);
    }

    public function createTask(array $data): Task
    {
        /** @var Task $task */
        $task = Task::query()
            ->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'due_date' => $data['due_date'],
                'board_id' => $data['board_id'],
                'creator_id' => $this->getKey(),
            ]);

        // Handle the file uploads
        if ($image = $data['image'] ?? false) {
            $path = $image->store('images');

            $task->images()->create([
                'address' => $path,
                'disk' => 'public',
            ]);
        }

        return $task;
    }
}
