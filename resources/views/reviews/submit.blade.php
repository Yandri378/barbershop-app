<!-- Review Submission Form -->
@if ($booking->status === 'completed' && !$booking->review)
    <div class="mt-4">
        <div class="card border-0 shadow-sm" style="background: var(--accent-color); border-left: 4px solid var(--secondary-color);">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2" style="color: var(--secondary-color);">
                    <i class="bi bi-star-fill"></i>
                    Bagikan Pengalaman Anda
                </h5>
                <p class="text-muted small mb-3">Membantu pelanggan lain memilih tukang cukur terbaik</p>

                <form action="{{ route('customer.reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <input type="hidden" name="barber_id" value="{{ $booking->barber_id }}">

                    <!-- Star Rating -->
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--light-text);">Rating</label>
                        <div class="star-rating d-flex gap-2" style="font-size: 2rem;">
                            @for ($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="d-none" required>
                                <label for="star{{ $i }}" class="star-label" style="cursor: pointer; color: #6c757d; transition: all 0.2s;">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-3">
                        <label for="comment" class="form-label" style="color: var(--light-text);">
                            Komentar (Opsional)
                        </label>
                        <textarea
                            id="comment"
                            name="comment"
                            class="form-control"
                            rows="3"
                            placeholder="Ceritakan pengalaman Anda dengan tukang cukur ini..."
                            maxlength="500"
                            style="background: var(--primary-color); color: var(--light-text); border-color: var(--secondary-color);"
                        ></textarea>
                        <small class="text-muted d-block mt-1">
                            <span id="charCount">0</span>/500 karakter
                        </small>
                        @error('comment')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn w-100" style="background: var(--secondary-color); color: var(--primary-color); font-weight: 600;">
                        <i class="bi bi-check-circle me-2"></i>Kirim Review
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .star-rating input:checked ~ .star-label,
        .star-label:hover,
        .star-label:hover ~ .star-label {
            color: var(--secondary-color) !important;
            transform: scale(1.2);
        }

        #comment {
            resize: vertical;
            transition: all 0.3s;
        }

        #comment:focus {
            border-color: var(--secondary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15);
        }
    </style>

    <script>
        // Update character count
        document.getElementById('comment').addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length;
        });

        // Star rating interactivity
        const stars = document.querySelectorAll('.star-rating input');
        stars.forEach((star, index) => {
            star.addEventListener('change', function() {
                stars.forEach((s, i) => {
                    const label = s.nextElementSibling;
                    if (i < index + 1) {
                        label.style.color = 'var(--secondary-color)';
                    } else {
                        label.style.color = '#6c757d';
                    }
                });
            });
        });
    </script>
@endif
