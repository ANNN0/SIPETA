                        <h2 class="product-single__reviews-title">Reviews</h2>

                        @if (session('review_success'))
                            <div class="alert alert-success">{{ session('review_success') }}</div>
                        @endif

                        <div class="product-single__reviews-list">
                            @forelse($product->approvedReviews as $review)
                                <div class="product-single__reviews-item">
                                    <div class="customer-avatar">
                                        <div
                                            style="width: 60px; height: 60px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; color: #666;">
                                            {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="customer-review">
                                        <div class="customer-name">
                                            <h6>{{ $review->reviewer_name }}</h6>
                                            <div class="reviews-group d-flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="review-star" viewBox="0 0 9 9"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        style="fill: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }}">
                                                        <use href="#icon_star" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review-date">{{ $review->created_at->format('F d, Y') }}</div>
                                        <div class="review-text">
                                            <p>{{ $review->review_text }}</p>
                                            @if ($review->image)
                                                <div class="review-image mt-2">
                                                    @php
                                                        $imageSrc = Str::startsWith($review->image, 'http')
                                                            ? $review->image
                                                            : asset('uploads/reviews/' . $review->image);
                                                    @endphp
                                                    <img src="{{ $imageSrc }}" alt="Review Image" class="img-fluid"
                                                        style="max-height: 150px; width: auto; border-radius: 12px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                            @endforelse
                        </div>

                        <div class="product-single__review-form">
                            <form action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <h5>Tulis Ulasan for "{{ $product->name }}"</h5>
                                <p>Email Anda address will not be published. Required fields are marked *</p>

                                <div class="select-star-rating">
                                    <label>Your rating *</label>
                                    <span class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="star-rating__star-icon" width="12" height="12"
                                                fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"
                                                data-star="{{ $i }}" style="cursor: pointer;">
                                                <path
                                                    d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                            </svg>
                                        @endfor
                                    </span>
                                    <input type="hidden" name="rating" id="form-input-rating" value=""
                                        required />
                                    @error('rating')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <textarea name="review" id="form-input-review" class="form-control form-control_gray" placeholder="Ulasan Anda *"
                                        cols="30" rows="8" required>{{ old('review') }}</textarea>
                                    @error('review')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="form-input-image" class="form-label">Upload Foto (Optional)</label>
                                    <input type="file" name="image" id="form-input-image"
                                        class="form-control form-control_gray" accept="image/*">
                                    @error('image')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-label-fixed mb-4">
                                    <label for="form-input-name" class="form-label">Name *</label>
                                    <input type="text" name="name" id="form-input-name"
                                        class="form-control form-control-md form-control_gray"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-label-fixed mb-4">
                                    <label for="form-input-email" class="form-label">Email address *</label>
                                    <input type="email" name="email" id="form-input-email"
                                        class="form-control form-control-md form-control_gray"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-action">
                                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                                </div>
                            </form>
                        </div>

                        <script>
                            // Star rating click handler
                            document.querySelectorAll('.star-rating__star-icon').forEach(star => {
                                star.addEventListener('click', function() {
                                    const rating = this.getAttribute('data-star');
                                    document.getElementById('form-input-rating').value = rating;

                                    // Update star colors
                                    document.querySelectorAll('.star-rating__star-icon').forEach(s => {
                                        const starValue = parseInt(s.getAttribute('data-star'));
                                        s.setAttribute('fill', starValue <= rating ? '#ffc107' : '#ccc');
                                    });
                                });
                            });
                        </script>
