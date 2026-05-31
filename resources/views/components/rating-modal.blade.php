<!-- Rating Modal Component -->
<div id="rating-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="w-full max-w-[536px] bg-white rounded-[32px] overflow-hidden shadow-xl">
        <!-- Modal Header -->
        <header class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <h1 class="text-2xl font-bold text-gray-800">Beri Ulasan</h1>
            <button type="button" onclick="closeRatingModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="24">
                    <line x1="18" x2="6" y1="6" y2="18"></line>
                    <line x1="6" x2="18" y1="6" y2="18"></line>
                </svg>
            </button>
        </header>

        <div class="px-8 pt-8 pb-10">
            <!-- Service Information -->
            <section class="bg-gray-50 rounded-xl p-5 flex items-center gap-4 mb-8">
                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                    <img id="service-icon" alt="Service Icon" class="w-full h-full object-cover opacity-60 mix-blend-multiply" src="">
                </div>
                <div>
                    <h2 id="service-name" class="font-bold text-lg text-gray-800 leading-tight">-</h2>
                    <p id="service-provider" class="text-gray-500 text-sm">-</p>
                </div>
            </section>

            <!-- Rating Stars Section -->
            <section class="flex flex-col items-center mb-8">
                <p class="text-gray-500 font-medium mb-3">Bagaimana pengalamanmu?</p>
                <div class="flex gap-2" id="star-rating">
                    <svg class="w-10 h-10 cursor-pointer transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" data-rating="1">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <svg class="w-10 h-10 cursor-pointer transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" data-rating="2">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <svg class="w-10 h-10 cursor-pointer transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" data-rating="3">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <svg class="w-10 h-10 cursor-pointer transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" data-rating="4">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <svg class="w-10 h-10 cursor-pointer transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" data-rating="5">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </section>

            <!-- Comment Field -->
            <section class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="review-comment">Komentar Ulasan</label>
                <textarea id="review-comment" class="w-full px-4 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#0073a5] focus:border-[#0073a5] text-gray-800 placeholder-gray-400 resize-none transition-shadow" placeholder="Ceritakan pengalamanmu menggunakan jasa ini..." rows="5"></textarea>
            </section>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="button" onclick="closeRatingModal()" class="flex-1 py-3.5 border border-gray-300 text-gray-600 font-bold rounded-full hover:bg-gray-50 transition-colors">
                    Nanti Saja
                </button>
                <button type="button" onclick="submitRating()" class="flex-1 py-3.5 bg-[#0073a5] text-white font-bold rounded-full hover:brightness-110 transition-all shadow-lg shadow-blue-500/20">
                    Kirim Ulasan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedRating = 0;
    let currentOrderId = null;

    function openRatingModal(orderId, serviceName, provider) {
        currentOrderId = orderId;
        document.getElementById('service-name').textContent = serviceName;
        document.getElementById('service-provider').textContent = provider;
        document.getElementById('rating-modal').classList.remove('hidden');
        selectedRating = 0;
        document.getElementById('review-comment').value = '';
        updateStarDisplay();
    }

    function closeRatingModal() {
    const starContainer = document.getElementById('star-rating');
    if (starContainer) {
        starContainer.addEventListener('mouseleave', updateStarDisplay);
    }
        selectedRating = 0;
        currentOrderId = null;
    }

    function updateStarDisplay() {
        document.querySelectorAll('#star-rating svg').forEach(star => {
            const rating = parseInt(star.dataset.rating);
            if (rating <= selectedRating) {
                star.setAttribute('fill', 'currentColor');
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300');
            } else {
                star.setAttribute('fill', 'none');
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    // Star rating interactivity
    document.querySelectorAll('#star-rating svg').forEach(star => {
        star.addEventListener('click', () => {
            selectedRating = parseInt(star.dataset.rating);
            updateStarDisplay();
        });
        star.addEventListener('mouseenter', () => {
            const hoverRating = parseInt(star.dataset.rating);
            document.querySelectorAll('#star-rating svg').forEach(s => {
                const rating = parseInt(s.dataset.rating);
                if (rating <= hoverRating) {
                    s.classList.add('text-yellow-400');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });

    document.getElementById('star-rating').addEventListener('mouseleave', updateStarDisplay);

    function submitRating() {
        if (!selectedRating) {
            alert('Silakan pilih rating terlebih dahulu');
            return;
        }

        const comment = document.getElementById('review-comment').value;
        
        // Send to server
        fetch('{{ route("user.orders.rating.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                order_id: currentOrderId,
                rating: selectedRating,
                comment: comment
            })
        }).then(async response => {
            let data = null;
            try {
                data = await response.json();
            } catch (_) {
                data = null;
            }

            if (!response.ok || (data && data.success === false)) {
                throw new Error((data && data.message) ? data.message : 'Gagal mengirim ulasan');
            }

            return data;
        })
          .then(data => {
              alert('Ulasan berhasil dikirim!');
              closeRatingModal();
              location.reload();
          })
          .catch(error => {
              console.error('Error:', error);
              alert('Gagal mengirim ulasan');
          });
    }
</script>
