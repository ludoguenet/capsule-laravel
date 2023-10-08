<?php

namespace App\Models;

use App\Enums\SchoolEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StudentCard extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'school',
        'description',
        'canteen_price',
        'is_internal',
        'date_of_birth',
    ];

    protected $casts = [
        'school' => SchoolEnum::class,
        'canteen_price' => 'integer',
        'is_internal' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('pdf')
            ->singleFile();
    }

    /**
     * @return BelongsTo<User, StudentCard>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphOne<Media>
     */
    public function pdfMedia(): MorphOne
    {
        return $this->morphOne(
            related: Media::class,
            name: 'model',
        );
    }
}
