<div class="w-100">
    @for ($i = 5; $i >= 1; $i--)
        @php
            $count = $ratingCounts[$i] ?? 0;
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        @endphp
        <div class="rating-wrrap hstack gap-2 align-items-center">
            <p class="mb-0">{{ $i }}</p>
            <div class=""><i class="bi bi-star"></i></div>
            <div class="progress flex-grow-1 mb-0 rounded-0" style="height: 4px;">
                <div class="progress-bar bg-{{ $i == 5 ? 'success' : ($i == 4 ? 'success' : ($i == 3 ? 'info' : ($i == 2 ? 'warning' : 'danger'))) }}" role="progressbar" style="width: {{ $percentage }}%"></div>
            </div>
            <p class="mb-0">{{ $count }}</p>
        </div>
    @endfor
</div>
