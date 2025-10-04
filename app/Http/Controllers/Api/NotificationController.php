<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\NotificationCollection;
use App\Models\User;

class NotificationController extends MainController
{
    public function index()
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $notifications = $user->notificationsUnread()->paginate($this->perPage);
        return $this->sendData(new NotificationCollection($notifications));
    }

    public function read($id)
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $notification = $user->notificationsUnread()->where('id', $id)->first();
        if (!$notification) {
            return $this->messageError(__('site.notification_not_found'));
        }
        $notification->markAsRead();
        return $this->messageSuccess(__('site.notification_read_successfully'));
    }

    public function readAll()
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $notifications = $user->notificationsUnread()->get();
        if ($notifications->count() == 0) {
            return $this->messageError(__('site.no_unread_notifications'));
        }
        $user->markNotificationAsRead($notifications);
        return $this->messageSuccess(__('site.notifications_read_successfully'));
    }

    public function destroy($id)
    {
        $auth=auth()->guard('api')->user();
        $user=User::find($auth->id);
        $notification = $user->notifications()->where('id', $id)->first();
        if (!$notification) {
            return $this->messageError(__('site.notification_not_found'));
        }
        $notification->delete();
        return $this->messageSuccess(__('site.notification_deleted_successfully'));
    }




}
