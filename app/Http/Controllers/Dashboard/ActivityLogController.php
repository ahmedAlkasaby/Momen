<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends MainController
{

     public function __construct()
    {
        parent::__construct();
        $this->setClass('activity_logs');
    }
    public function index()
    {
        $activityLogs=ActivityLog::with('user')->filter()->paginate($this->perPage);
        return view('admin.activity_logs.index',compact('activityLogs'));
    }
}
