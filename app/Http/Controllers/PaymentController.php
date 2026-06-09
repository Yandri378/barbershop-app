<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function show(Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        $payment = $booking->payment;

        return view('payments.show', compact('booking', 'payment'));
    }

    /**
     * Show payment confirmation form (for customers)
     */
    public function showConfirmation(Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        $payment = $booking->payment;

        return view('payments.confirmation', compact('booking', 'payment'));
    }

    /**
     * Submit payment confirmation
     */
    public function submitPayment(Request $request, Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:transfer,cash',
            'transaction_id' => 'required_if:payment_method,transfer|nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ], [
            'transaction_id.required_if' => 'ID transaksi wajib diisi untuk pembayaran transfer.',
        ]);

        $payment = $booking->payment;
        $payment->update([
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'],
            'notes' => $validated['notes'],
            'status' => 'pending', // Admin will confirm it
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }

    /**
     * Admin - View all payments
     */
    public function index()
    {
        $payments = Payment::with('booking', 'booking.customer', 'booking.barber', 'booking.service')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Admin - Show payment details
     */
    public function showAdmin(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Admin - Mark payment as paid
     */
    public function markAsPaid(Payment $payment)
    {
        $payment->update(['status' => 'paid']);
        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * Admin - Mark payment as failed
     */
    public function markAsFailed(Payment $payment)
    {
        $payment->update(['status' => 'failed']);
        return back()->with('success', 'Pembayaran ditandai sebagai gagal.');
    }
}
