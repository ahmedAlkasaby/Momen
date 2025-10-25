@extends('admin.layouts.app')
@section('title', __('site.settings'))
@section('styles')
    @include('admin.layouts.table.datatablesCss')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('content')
    @include('admin.layouts.messages.success')
    @include('admin.layouts.messages.displayErrors')
    <div class="card">
        @include('admin.settings.includes.table')
    </div>
    </div>

@endsection

@section('mainFiles')
    <script src="{{ asset('admin/assets/js/modal-add-new-address.js') }}"></script>
@endsection
@section('jsFiles')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    @include('admin.layouts.table.dataTableJs', ['table' => $settings->count() > 0])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // تهيئة عنوان الـ CSRF لكل طلبات AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // دالة لتفعيل وضع التعديل (تحويل النص إلى حقل إدخال)
    function enableEdit(key) {
        let valueSpan = $(`#value-span-${key}`);
        let currentValue = valueSpan.text().trim();
        
        // استبدال النص بحقل إدخال
        let inputField = `<input type="text" class="form-control form-control-sm" value="${currentValue}" id="input-${key}" />`;
        valueSpan.html(inputField);

        // تبديل الأزرار
        $(`#edit-btn-${key}`).hide();
        $(`#save-btn-${key}`).show();
        $(`#cancel-btn-${key}`).show();
    }

    // دالة لإلغاء التعديل (العودة إلى النص العادي)
    function cancelEdit(key) {
        let valueSpan = $(`#value-span-${key}`);
        let inputField = $(`#input-${key}`);
        let originalValue = inputField.val(); // القيمة الأصلية قبل التعديل

        // استبدال حقل الإدخال بالنص الأصلي
        valueSpan.text(originalValue);

        // تبديل الأزرار
        $(`#edit-btn-${key}`).show();
        $(`#save-btn-${key}`).hide();
        $(`#cancel-btn-${key}`).hide();
    }

    // دالة حفظ التعديل عبر AJAX
    function saveSetting(key) {
        let inputField = $(`#input-${key}`);
        let newValue = inputField.val();

        // عرض رسالة تحميل لطيفة
        Swal.fire({
            title: '{{ __("site.saving") }}...',
            text: '{{ __("site.please_wait") }}',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
        });

        $.ajax({
            url: "/dashboard/settings/update-single",
            method: 'PATCH', // أو POST
            data: {
                key: key,
                value: newValue,
            },
            success: function(response) {
                // تحديث النص بعد النجاح
                let valueSpan = $(`#value-span-${key}`);
                valueSpan.text(response.value);

                // إخفاء أزرار الحفظ والإلغاء
                $(`#save-btn-${key}`).hide();
                $(`#cancel-btn-${key}`).hide();
                $(`#edit-btn-${key}`).show();

                // رسالة نجاح
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("site.success") }}',
                    text: '{{ __("site.updated_successfully") }}',
                    showConfirmButton: false,
                    timer: 1500
                });

                // تحديث الـ site_title في لوحة التحكم بشكل فوري إذا تم تعديله
                if (key === 'site_title') {
                    document.title = newValue; // تحديث عنوان الصفحة
                    // يمكنك تحديث أي مكان آخر يعرض الـ site_title في الـ Dashboard
                }
            },
            error: function(xhr) {
                let errorMessage = '{{ __("site.something_went_wrong") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // إعادة قيمة الحقل إلى القيمة السابقة إذا فشل التحديث
                let valueSpan = $(`#value-span-${key}`);
                let oldValue = valueSpan.find('input').data('old-value'); 
                valueSpan.text(oldValue);

                // رسالة خطأ
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("site.error") }}',
                    text: errorMessage,
                });
                
                // إخفاء أزرار الحفظ والإلغاء والعودة لزر التعديل
                $(`#save-btn-${key}`).hide();
                $(`#cancel-btn-${key}`).hide();
                $(`#edit-btn-${key}`).show();
            }
        });
    }

</script>
@endsection
