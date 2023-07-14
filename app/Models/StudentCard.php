<?php

namespace App\Models;

use App\Enums\SchoolEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school',
        'description',
        'is_internal',
        'date_of_birth',
    ];

    protected $casts = [
        'school' => SchoolEnum::class,
        'is_internal' => 'boolean',
        'date_of_birth' => 'date',
    ];

    /**
     * @return BelongsTo<User, StudentCard>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
