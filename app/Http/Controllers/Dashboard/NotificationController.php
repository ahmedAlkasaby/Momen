<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\NotificationEvent;
use App\Helpers\ActionNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;

class NotificationController extends MainController
{
    protected $firebaseNotification;

    public function __construct(FirebaseNotificationService $firebaseNotification)
    {
        parent::__construct();
        $this->setClass('notifications');
        $this->firebaseNotification = $firebaseNotification;
    }


    public function index()
    {
        $notifications = Notification::filter()->with('user')->paginate($this->perPage);
        $users = User::get()->mapWithKeys(function ($user) {
            return [$user->id => $user->name];
        })->toArray();
        if (request('action') == 'delete') {
            return  $this->deleteAll();
        }
        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    public function show(string $id)
    {
        $notification = Notification::findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }
    public function create()
    {
        $types = ActionNotificationHelper::getTypes();
        $devices = ActionNotificationHelper::getDevices();
        $users = User::all()->mapWithKeys(fn($user) => [$user->id => $user->name])->toArray();

        return view('admin.notifications.create', compact('types', 'devices', 'users'));
    }


    public function store(Request $request)
    {

        if ($request->type == 'all' || $request->type == 'database') {
            $notification = Notification::create($request->all());
            event(new NotificationEvent($notification));
        }
        if ($request->type == 'all' || $request->type == 'firebase') {
            $dataFirebase = [
                'title' => json_encode([
                    'ar' => $request->name['ar'],
                    'en' => $request->name['en'],
                ]),
                'body' => json_encode([
                    'ar' => $request->description['ar'],
                    'en' => $request->description['en'],
                ]),
            ];
            $user = User::find($request->user_id);
            if ($user->devices()->count() > 0) {
                foreach ($user->devices as $device) {
                    if ($request->type == 'all' || $device->type == $request->type) {

                        $this->firebaseNotification->sendNotificationWithDevice(
                            $device,
                            $request->name['ar'],
                            $request->description['ar'],
                            $dataFirebase,
                        );
                    }
                }
            }
        }
        return redirect()->route('dashboard.notifications.index')->with('success', __('site.added_successfully'));
    }

    public function deleteAll()
    {
        Notification::filter()->forceDelete();
        return redirect()->route('dashboard.notifications.index')->with('success', __('site.deleted_successfully'));
    }




    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }
}
