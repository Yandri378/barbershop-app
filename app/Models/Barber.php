<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'bio',
        'photo',
        'status',
        'experience_years',
    ];

    /**
     * Get all bookings for this barber
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all reviews for this barber
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get average rating for this barber
     */
    public function getAverageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get review count for this barber
     */
    public function getReviewCount()
    {
        return $this->reviews()->count();
    }

    /**
     * Get current status label in Indonesian
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'busy' => 'Sedang Melayani',
            'break' => 'Istirahat',
            default => $this->status,
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'available' => 'success',
            'busy' => 'danger',
            'break' => 'warning',
            default => 'secondary',
        };
    }
}
