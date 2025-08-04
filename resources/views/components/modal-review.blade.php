{{-- Komponen Modal untuk Form Ulasan --}}
<div 
    x-show="showReviewModal" 
    x-on:keydown.escape.window="showReviewModal = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75"
    style="display: none;"
    x-cloak
>
    <div 
        @click.away="showReviewModal = false"
        class="w-full max-w-lg mx-4 bg-white rounded-lg shadow-xl overflow-hidden"
    >
        <form :action="reviewAction" method="POST">
            @csrf
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900" x-text="'Beri ulasan untuk ' + reviewMenuName"></h3>
                
                {{-- Input Rating Bintang Interaktif --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Rating Anda</label>
                    <div class="mt-1 flex items-center" x-data="{ rating: 0, hoverRating: 0 }">
                        <input type="hidden" name="rating" x-model="rating">
                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                            <svg @click="rating = star" 
                                 @mouseenter="hoverRating = star" 
                                 @mouseleave="hoverRating = 0"
                                 :class="{
                                     'text-yellow-400': hoverRating >= star || rating >= star,
                                     'text-gray-300': !(hoverRating >= star || rating >= star)
                                 }"
                                 class="w-8 h-8 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.175 0l-3.368 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.06 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" />
                            </svg>
                        </template>
                    </div>
                </div>

                {{-- Input Komentar --}}
                <div class="mt-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700">Komentar (Opsional)</label>
                    <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                {{-- Hidden input untuk menu_id --}}
                <input type="hidden" name="menu_id" x-model="reviewMenuId">
            </div>

            {{-- Tombol Aksi --}}
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 sm:ml-3 sm:w-auto">
                    Kirim Ulasan
                </button>
                <button @click="showReviewModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
