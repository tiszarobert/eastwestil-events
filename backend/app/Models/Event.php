<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'location',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
