<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show customer dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::where('customer_id', $user->id)
            ->with('barber', 'service', 'payment')
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        $stats = [
            'total_bookings' => Booking::where('customer_id', $user->id)->count(),
            'pending_bookings' => Booking::where('customer_id', $user->id)->where('status', 'pending')->count(),
            'approved_bookings' => Booking::where('customer_id', $user->id)->where('status', 'approved')->count(),
            'completed_bookings' => Booking::where('customer_id', $user->id)->where('status', 'completed')->count(),
        ];

        return view('customer.dashboard', compact('bookings', 'stats'));
    }
}
