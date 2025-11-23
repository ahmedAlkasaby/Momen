<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center gap-2 gap-sm-0">
            <h5 class="mb-1 mt-3 d-flex flex-wrap gap-2 align-items-end">
                {{ $order->user->name }}
                <span class="badge {{ $spanClass }}">{{ $order->status->label() }}</span>
            </h5>
            <p class="text-body">{{ $order->created_at->diffForHumans() }}</p>
        </div>
        
    </div>