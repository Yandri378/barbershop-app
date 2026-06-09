<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Barber;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show the booking form
     */
    public function create()
    {
        // Filter to show only "Modern Trendy Haircut" service for booking
        $services = Service::where('name', 'like', '%modern%')->orWhere('name', 'like', '%trendy%')->get();
        
        // If no services found with those keywords, show the "Paket Lengkap" as the main booking option
        if ($services->isEmpty()) {
            $services = Service::where('price', 75000)->get();
        }
        
        $barbers = Barber::all();
        return view('bookings.create', compact('services', 'barbers'));
    }

    /**
     * Store a new booking with transaction support to prevent race conditions
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date_format:Y-m-d|after:today',
            'time' => 'required|date_format:H:i',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // Combine date and time
            $bookingDateTime = $validated['booking_date'] . ' ' . $validated['time'];
            
            // Check if time slot is still available (prevents race condition)
            $existingBooking = Booking::where('barber_id', $validated['barber_id'])
                ->where('booking_date', $bookingDateTime)
                ->where('status', '!=', 'cancelled')
                ->lockForUpdate()
                ->first();
            
            if ($existingBooking) {
                return back()->with('error', 'Jam yang dipilih sudah dipesan. Silakan pilih jam lain.');
            }

            $booking = Booking::create([
                'customer_id' => Auth::id(),
                'barber_id' => $validated['barber_id'],
                'service_id' => $validated['service_id'],
                'booking_date' => $bookingDateTime,
                'status' => 'pending',
            ]);

            // Create payment record
            $service = Service::find($validated['service_id']);
            if ($service) {
                $booking->payment()->create([
                    'amount' => $service->price,
                    'status' => 'pending',
                ]);
            }

            return redirect()->route('customer.dashboard')->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi admin.');
        });
    }

    /**
     * Show booking details
     */
    public function show(Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($booking->status, ['pending', 'approved'])) {
            return back()->with('error', 'Hanya booking yang pending atau approved yang bisa dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Get available time slots for a barber
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $barber = Barber::find($request->barber_id);
        $date = $request->date;

        // Get all bookings for this barber on this date
        $bookings = Booking::where('barber_id', $barber->id)
            ->whereDate('booking_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('booking_date')
            ->toArray();

        // Generate time slots (9 AM to 5 PM, 30 min intervals)
        $slots = [];
        $start = strtotime('09:00');
        $end = strtotime('17:00');
        $interval = 30 * 60;

        for ($time = $start; $time <= $end; $time += $interval) {
            $timeString = date('H:i', $time);
            $slots[] = [
                'time' => $timeString,
                'available' => !$this->isTimeSlotBooked($date, $timeString, $bookings),
            ];
        }

        return response()->json($slots);
    }

    /**
     * Check if a time slot is booked
     */
    private function isTimeSlotBooked($date, $time, $bookings)
    {
        $checkDateTime = strtotime($date . ' ' . $time);

        foreach ($bookings as $booking) {
            $bookingTime = strtotime($booking);
            // Allow 30 min gap between bookings
            if (abs($checkDateTime - $bookingTime) < 1800) {
                return true;
            }
        }

        return false;
    }
}
