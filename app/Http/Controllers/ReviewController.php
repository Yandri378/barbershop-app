<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Barber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'barber_id' => 'required|exists:barbers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ], [
            'booking_id.required' => 'Booking ID harus dipilih',
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.max' => 'Komentar maksimal 500 karakter',
        ]);

        $booking = Booking::find($validated['booking_id']);
        
        // Check if user is the owner of the booking
        if ($booking->customer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak memberikan review untuk booking ini');
        }

        // Check if booking is already completed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'Hanya booking yang sudah selesai yang bisa diberi review');
        }

        // Check if review already exists
        if (Review::where('booking_id', $validated['booking_id'])->exists()) {
            return back()->with('error', 'Anda sudah memberikan review untuk booking ini');
        }

        $validated['customer_id'] = Auth::id();

        Review::create($validated);

        return back()->with('success', 'Terima kasih! Review Anda telah disimpan');
    }

    public function getBarberRating($barberId)
    {
        $barber = Barber::findOrFail($barberId);
        
        $stats = Review::where('barber_id', $barberId)
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as total_reviews')
            ->first();

        return response()->json([
            'barber_id' => $barberId,
            'average_rating' => round($stats->average_rating ?? 0, 1),
            'total_reviews' => $stats->total_reviews ?? 0,
        ]);
    }

    public function destroy(Review $review)
    {
        if ($review->customer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak berhak menghapus review ini');
        }

        $review->delete();
        return back()->with('success', 'Review berhasil dihapus');
    }
}
