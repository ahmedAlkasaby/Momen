<?php 
use App\Enums\StatusOrderEnum;
use Carbon\Carbon;
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title m-0">{{ __('site.shipping_activity') }}</h5>
            </div>
            <div class="card-body">
                <ul class="timeline pb-0 mb-0">
                    @foreach ($statuses as $key => $data)

                        @php
                            $index = array_search($key, $orderFlow);
                            $isActive = $index !== false && $index <= $currentIndex;
                            $time = $statusTimes[$key] ?? null;
                        @endphp

                        <li class="timeline-item timeline-item-transparent {{ $isActive ? 'border-primary' : 'border-secondary' }}">
                            <span class="timeline-point {{ $isActive ? 'timeline-point-primary' : 'timeline-point-secondary' }}"></span>

                            <div class="timeline-event">
                                <div class="timeline-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $data['label'] }}</h6>

                                    @if ($time)
                                        <span class="text-muted">{{ Carbon::parse($time)->format('l h:i A') }}</span>
                                    @endif
                                </div>
                            </div>
                        </li>

                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
