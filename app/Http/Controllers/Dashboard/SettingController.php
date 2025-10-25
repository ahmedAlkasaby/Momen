<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageHandlerService;
use Illuminate\Support\Facades\Storage;

class SettingController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected $imageService;
    public function __construct(ImageHandlerService $imageHandlerService)
    {
        parent::__construct();
        $this->setClass('settings');
        $this->imageService = $imageHandlerService;
    }
    public function index()
    {
        $settings=Setting::filter(request())->paginate($this->perPage);

        return view('admin.settings.index', compact('settings'));
    }

    
   
   public function update(Request $request)
    {
           
        $key = $request->input('key');
        $value = $request->input('value');

        $request->validate([
            'key' => 'required|string|max:255|exists:settings,key', // تأكد أن المفتاح موجود
            'value' => 'nullable|string',
        ]);
        
        // *استثناء خاص للصور إذا كان لديك*
        // إذا كان الإعداد صورة، فستحتاج لمعالجة خاصة لها (وهذا خارج نطاق التعديل الفردي للنص)
        // لكن لتبسيط الأمور حاليًا، سنركز على الحقول النصية.

        // 2. تحديث القيمة في قاعدة البيانات
        $updated = Setting::where('key', $key)->update(['value' => $value]);

        // 3. تحديث قيمة الإعداد في الـ Session/Cache (حسب الـ Helper function setting() لديك)
        // إذا كان لديك طريقة لتحديث الإعدادات المخزنة مؤقتاً، أضفها هنا.
        // مثلاً، إذا كان لديك Helper function مثل `setting()`, ربما تحتاج إلى تحديثها:
        // if (function_exists('forget_setting_cache')) {
        //     forget_setting_cache($key);
        // }

        if ($updated) {
         
            
            return response()->json([
                'success' => true,
                'message' => __('site.updated_successfully'), // رسالة نجاح من ملف الترجمة
                'key' => $key,
                'value' => $value,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('site.something_went_wrong'), // رسالة خطأ
        ], 500);
    }
    
    
}
