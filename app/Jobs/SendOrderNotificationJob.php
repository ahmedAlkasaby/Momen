<?php

namespace App\Jobs;


use App\Helpers\OrderNotificationData;
use App\Models\Notification;
use App\Models\User;
use App\Services\FirebaseNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendOrderNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $statusOrder;
    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, string $statusOrder = 'request')
    {
        $this->statusOrder = $statusOrder;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(FirebaseNotificationService $firebaseNotification): void
    {
        $admins = User::where('type', 'admin')
            ->where('is_notify', 1)
            ->where('active', 1)
            ->get();

        $notificationData = OrderNotificationData::getData($this->statusOrder);
        Notification::send(
            $admins,
            $notificationData['title_ar'],
            $notificationData['title_en'],
            $notificationData['body_ar'],
            $notificationData['body_en']
        );

        $dataFirebase = [
            'title' => json_encode([
                'ar' => $notificationData['title_ar'],
                'en' => $notificationData['title_en'],
            ]),
            'body' => json_encode([
                'ar' => $notificationData['body_ar'],
                'en' => $notificationData['body_en'],
            ]),
        ];

        $user = User::with('devices')->find($this->userId);
        if (!$user) {
            return;
        }

        foreach ($user->devices as $device) {
            $firebaseNotification->sendNotificationWithDevice(
                $device,
                $notificationData['title_ar'],
                $notificationData['body_ar'],
                $dataFirebase
            );
        }
    }
}
