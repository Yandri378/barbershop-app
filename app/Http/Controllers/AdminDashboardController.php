<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Barber;
use App\Models\Service;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'approved_bookings' => Booking::where('status', 'approved')->count(),
            'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->sum('amount'),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_barbers' => Barber::count(),
        ];

        $recentBookings = Booking::with('customer', 'barber', 'service', 'payment')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    /**
     * Show all bookings for admin
     */
    public function bookings(Request $request)
    {
        $query = Booking::with('customer', 'barber', 'service', 'payment');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by customer name or email
        if ($request->has('search') && $request->search !== '') {
            $query->whereHas('customer', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('email', 'like', '%' . request('search') . '%');
            });
        }

        $bookings = $query->orderBy('booking_date', 'desc')->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show booking details for admin
     */
    public function showBooking(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Approve a booking
     */
    public function approveBooking(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking pending yang bisa disetujui.');
        }

        $booking->update(['status' => 'approved']);
        
        // Update barber status if needed
        if ($booking->barber->status === 'available') {
            $booking->barber->update(['status' => 'busy']);
        }

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    /**
     * Reject a booking
     */
    public function rejectBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking pending yang bisa ditolak.');
        }

        $booking->update([
            'status' => 'rejected',
            'notes' => $request->reason,
        ]);

        return back()->with('success', 'Booking berhasil ditolak.');
    }

    /**
     * Complete a booking
     */
    public function completeBooking(Booking $booking)
    {
        if ($booking->status !== 'approved') {
            return back()->with('error', 'Hanya booking approved yang bisa diselesaikan.');
        }

        $booking->update(['status' => 'completed']);
        
        // Reset barber status to available
        $booking->barber->update(['status' => 'available']);

        return back()->with('success', 'Booking berhasil diselesaikan.');
    }

    /**
     * Manage barbers
     */
    public function barbers()
    {
        $barbers = Barber::with('bookings')->paginate(10);
        return view('admin.barbers.index', compact('barbers'));
    }

    /**
     * Create barber form
     */
    public function createBarber()
    {
        return view('admin.barbers.create');
    }

    /**
     * Store barber
     */
    public function storeBarber(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'experience_years' => 'required|integer|min:0',
        ]);

        Barber::create($validated);

        return redirect()->route('admin.barbers.index')->with('success', 'Tukang cukur berhasil ditambahkan.');
    }

    /**
     * Edit barber form
     */
    public function editBarber(Barber $barber)
    {
        return view('admin.barbers.edit', compact('barber'));
    }

    /**
     * Update barber
     */
    public function updateBarber(Request $request, Barber $barber)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'status' => 'required|in:available,busy,break',
            'experience_years' => 'required|integer|min:0',
        ]);

        $barber->update($validated);

        return redirect()->route('admin.barbers.index')->with('success', 'Tukang cukur berhasil diperbarui.');
    }

    /**
     * Delete barber
     */
    public function deleteBarber(Barber $barber)
    {
        // Check if barber has active bookings
        $activeBookings = $barber->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->count();
        
        if ($activeBookings > 0) {
            return back()->with('error', 'Tidak dapat menghapus tukang cukur yang memiliki booking aktif. Selesaikan atau batalkan booking terlebih dahulu.');
        }
        
        $barber->delete();
        return redirect()->route('admin.barbers.index')->with('success', 'Tukang cukur berhasil dihapus.');
    }

    /**
     * Manage services
     */
    public function services()
    {
        $services = Service::with('bookings')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Create service form
     */
    public function createService()
    {
        return view('admin.services.create');
    }

    /**
     * Store service
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Edit service form
     */
    public function editService(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update service
     */
    public function updateService(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Delete service
     */
    public function deleteService(Service $service)
    {
        // Check if service has associated bookings
        $bookingCount = $service->bookings()
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->count();
        
        if ($bookingCount > 0) {
            return back()->with('error', 'Tidak dapat menghapus layanan yang sudah memiliki booking. Hapus booking terlebih dahulu.');
        }
        
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Manage payments
     */
    public function payments()
    {
        $payments = Payment::with('booking', 'booking.customer', 'booking.barber')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        $payment->update(['status' => $request->status]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
