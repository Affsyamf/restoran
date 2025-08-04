@props([
    'rating' => 0,
    'count' => null // Jadikan count opsional
])

<div class="flex items-center">
    {{-- Bagian ini akan selalu menampilkan bintang berdasarkan rating --}}
    <div class="flex items-center">
        @for ($i = 1; $i <= 5; $i++)
            <svg @class([
                'w-4 h-4',
                'text-yellow-400' => $i <= round($rating),
                'text-gray-300' => $i > round($rating)
            ]) fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.175 0l-3.368 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.06 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" />
            </svg>
        @endfor
    </div>
    
    {{-- Bagian ini hanya akan tampil jika properti 'count' dikirimkan --}}
    @if(isset($count))
        @if($count > 0)
            <p class="ml-2 text-xs text-gray-500">{{ $count }} ulasan</p>
        @else
            <p class="ml-2 text-xs text-gray-500">Belum ada ulasan</p>
        @endif
    @endif
</div>
