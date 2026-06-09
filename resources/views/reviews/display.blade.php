<!-- Display Reviews for a Booking or Barber -->
@if ($booking && $booking->review)
    <div class="mt-4">
        <h5 class="d-flex align-items-center gap-2 mb-3" style="color: var(--secondary-color);">
            <i class="bi bi-chat-quote"></i>
            Review Anda
        </h5>
        <div class="card border-0 shadow-sm" style="background: var(--accent-color);">
            <div class="card-body">
                <!-- Review Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <p class="mb-0" style="color: var(--light-text); font-weight: 600;">
                            {{ $booking->review->customer->name }}
                        </p>
                        <small class="text-muted">
                            {{ $booking->review->created_at->format('d M Y') }}
                        </small>
                    </div>
                    @if ($booking->review->customer_id === Auth::id())
                        <form action="{{ route('customer.reviews.destroy', $booking->review) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus review ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Star Rating Display -->
                <div class="mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $booking->review->rating)
                            <i class="bi bi-star-fill" style="color: var(--secondary-color);"></i>
                        @else
                            <i class="bi bi-star" style="color: #6c757d;"></i>
                        @endif
                    @endfor
                    <span class="ms-2" style="color: var(--secondary-color); font-weight: 600;">
                        {{ $booking->review->rating }}/5
                    </span>
                </div>

                <!-- Review Comment -->
                @if ($booking->review->comment)
                    <p class="mb-0" style="color: var(--light-text);">
                        {{ $booking->review->comment }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Display All Reviews for a Barber -->
@if (isset($allReviews) && count($allReviews) > 0)
    <div class="mt-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="d-flex align-items-center gap-2 mb-0" style="color: var(--secondary-color);">
                <i class="bi bi-chat-dots"></i>
                Ulasan Pelanggan
            </h5>
            <span class="badge" style="background: var(--secondary-color); color: var(--primary-color);">
                {{ count($allReviews) }} ulasan
            </span>
        </div>

        <div class="review-list">
            @foreach ($allReviews as $review)
                <div class="card border-0 shadow-sm mb-3" style="background: var(--accent-color);">
                    <div class="card-body">
                        <!-- Review Header -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="mb-0" style="color: var(--light-text); font-weight: 600;">
                                    {{ $review->customer->name }}
                                </p>
                                <small class="text-muted">
                                    {{ $review->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>

                        <!-- Star Rating -->
                        <div class="mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="bi bi-star-fill" style="color: var(--secondary-color);"></i>
                                @else
                                    <i class="bi bi-star" style="color: #6c757d;"></i>
                                @endif
                            @endfor
                            <span class="ms-2" style="color: var(--secondary-color); font-weight: 600;">
                                {{ $review->rating }}/5
                            </span>
                        </div>

                        <!-- Comment -->
                        @if ($review->comment)
                            <p class="mb-0" style="color: var(--light-text);">
                                {{ $review->comment }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@elseif (isset($allReviews))
    <div class="mt-4 text-center" style="color: #6c757d;">
        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
        <p class="mt-2">Belum ada ulasan untuk tukang cukur ini</p>
    </div>
@endif
