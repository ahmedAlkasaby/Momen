<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TrashBucket;
use Illuminate\Http\Request;

class TrashBucketController extends MainController
{
     public function __construct()
    {
        parent::__construct();
        $this->setClass('trash_buckets');
    }
    public function index()
    {
        $trashBuckets=TrashBucket::with(['user','model'])->filter()->paginate($this->perPage);
        return view('admin.trash_buckets.index',compact('trashBuckets'));
    }

    public function restore($id)
    {
        $trashBucket = TrashBucket::findOrFail($id);
        $modelClass = $trashBucket->model_type;
        $modelId = $trashBucket->model_id;

        if (class_exists($modelClass)) {
            $modelInstance = $modelClass::withTrashed()->find($modelId);
            if ($modelInstance) {
                $modelInstance->restore();
                $trashBucket->delete(); 
                return redirect()->route('dashboard.trash_buckets.index')->with('success', __('site.restore_successfully'));
            }
        }

        return redirect()->route('dashboard.trash_buckets.index')->with('error', __('site.restore_failed'));
    }
}
