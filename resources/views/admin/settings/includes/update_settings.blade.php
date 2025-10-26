    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- يجب أن يكون jQuery محملًا --}}

    <script>
        // دالة لعرض الصورة في Modal (SweetAlert2)
        function viewImage(url) {
            Swal.fire({
                title: '{{ __('site.image_preview') }}',
                imageUrl: url,
                imageAlt: '{{ __('site.setting_image') }}',
                imageWidth: 'auto',
                imageHeight: 'auto',
                showCloseButton: true,
                showConfirmButton: false,
                backdrop: true,
            });
        }

        // 1. تهيئة عنوان الـ CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 2. دالة تفعيل وضع التعديل (لتحديد نوع الحقل)
        function enableEdit(key) {
            let valueSpan = $(`#value-span-${key}`);
            let currentValue = valueSpan.attr('data-original-value').trim();
            let settingRow = $(`#setting-row-${key}`);
            let inputType = settingRow.data('type');

            let htmlInput = '';
            switch (inputType) {
                case 'select':
                    // هذا هو الحقل الذي تريده (الـ options): 10, 20, 50, 100, 250
                    let selectOptions = @json(getResultPaginateOptions());
                    let optionsHtml = '';

                    selectOptions.forEach(option => {
                        let selected = (currentValue == option) ? 'selected' : '';
                        optionsHtml += `<option value="${option}" ${selected}>${option}</option>`;
                    });

                    htmlInput = `
                <select class="form-control form-control-sm" id="input-${key}">
                    ${optionsHtml}
                </select>
            `;
                    break;
                case 'number':
                    htmlInput =
                        `<input type="number" step="any" class="form-control form-control-sm" value="${currentValue}" id="input-${key}" />`;
                    break;
                case 'file':
                    // 💡 نستخدم حقل File هنا
                    htmlInput = `<input type="file" class="form-control form-control-sm" id="input-${key}" />`;
                    // يمكنك إضافة عرض للوجو الحالي هنا أيضاً
                    break;
                case 'boolean':
                    htmlInput = `
                    <select class="form-control form-control-sm" id="input-${key}">
                        <option value="yes" ${currentValue === 'yes' ? 'selected' : ''}>{{ __('site.yes') }}</option>
                        <option value="no" ${currentValue === 'no' ? 'selected' : ''}>{{ __('site.no') }}</option>
                    </select>
                    `;
                    break;
                case 'text':
                case 'email':
                    htmlInput =
                        `<input type="${inputType}" class="form-control form-control-sm" value="${currentValue}" id="input-${key}" />`;
                    break;
                case 'url':
                    htmlInput =
                        `<input type="url" class="form-control form-control-sm" value="${currentValue}" id="input-${key}" />`;
                    break;
                default:
                    htmlInput =
                        `<input type="text" class="form-control form-control-sm" value="${currentValue}" id="input-${key}" />`;
            }

            valueSpan.html(htmlInput);

            // تبديل الأزرار
            $(`#edit-btn-${key}`).hide();
            $(`#save-btn-${key}`).show();
            $(`#cancel-btn-${key}`).show();
        }

        // 3. دالة إلغاء التعديل
        function cancelEdit(key) {
            let valueSpan = $(`#value-span-${key}`);
            // نستخدم القيمة الأصلية المخزنة
            let originalValue = valueSpan.attr('data-original-value');

            let settingRow = $(`#setting-row-${key}`);
            let inputType = settingRow.data('type');

            let displayHtml = originalValue;

            if (inputType === 'file' && originalValue && originalValue !== 'null') {
                // تنظيف السلاش من بداية المسار إذا كان موجودًا
                if (originalValue.startsWith('/')) {
                    originalValue = originalValue.substring(1);
                }

                // بناء المسار الكامل
                let imageUrl = '{{ asset('') }}' + originalValue;

                // 💡 التعديل هنا: يجب مطابقة كل الأوسمة والتنسيقات من كود Blade الأصلي
                displayHtml = `
                <img src="${imageUrl}" 
                     onclick="viewImage('${imageUrl}')"
                     onerror="this.onerror=null;this.src='//:0'" 
                     class="clickable-image"
                     style="max-width: 80px; max-height: 80px; cursor: pointer; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            `;
            } else if (inputType !== 'file') {
                // في حالة النصوص، لا تفعل شيئًا، فقط اعرض القيمة الأصلية
                displayHtml = originalValue;
            }

            valueSpan.html(displayHtml);

            // تبديل الأزرار
            $(`#edit-btn-${key}`).show();
            $(`#save-btn-${key}`).hide();
            $(`#cancel-btn-${key}`).hide();
        }

        // 4. دالة حفظ التعديل (تدعم FormData للملفات)
        function saveSetting(key) {
            let inputField = $(`#input-${key}`);
            let settingRow = $(`#setting-row-${key}`);
            let inputType = settingRow.data('type');

            let dataToSend = {};
            let ajaxSettings = {};

            // تحديد البيانات وطريقة الإرسال بناءً على النوع
            if (inputType === 'file') {
                if (inputField[0].files.length === 0) {
                    // إذا لم يتم اختيار ملف جديد (الـ value فارغ)
                    dataToSend = {
                        key: key,
                        value: settingRow.attr('data-original-value') || null,
                    };
                } else {
                    dataToSend = new FormData();
                    dataToSend.append('key', key);
                    dataToSend.append('value', inputField[0].files[0]); // إرسال الملف باسم 'value'

                    ajaxSettings = {
                        processData: false, // لا تعالج البيانات
                        contentType: false // لا تضبط نوع المحتوى
                    };
                }

            } else {
                // إذا كان نص أو رقم أو اختيار
                dataToSend = {
                    key: key,
                    value: inputField.val(),
                };
            }

            // عرض رسالة تحميل لطيفة
            Swal.fire({
                title: '{{ __('site.saving') }}...',
                text: '{{ __('site.please_wait') }}',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
            });

            // 5. إرسال طلب AJAX
            $.ajax({
                url: "{{ route('dashboard.settings.update-single') }}",
                method: 'POST', // متطابق مع تعريف الراوت POST
                data: dataToSend,
                ...ajaxSettings,

                success: function(response) {
                    // 💡 الأهم هنا: تحديث القيمة الأصلية بالمسار الجديد الذي عاد من الكنترولر
                    $(`#value-span-${key}`).attr('data-original-value', response.value);

                    // إعادة عرض القيمة بعد النجاح (ستقوم دالة cancelEdit بعرض الصورة الجديدة)
                    cancelEdit(key);

                    // رسالة نجاح
                    Swal.fire({
                        title: '{{ __('site.success') }}',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: '{{ __('site.ok') }}',
                    });
                },
                error: function(xhr) {
                    let errorMessage = '{{ __('site.something_went_wrong') }}';
                    // معالجة أخطاء الـ Validation
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    // إخفاء التحميل وعرض رسالة الخطأ
                    Swal.fire({
                        title: '{{ __('site.error') }}',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: '{{ __('site.ok') }}',
                    });

                    // إلغاء وضع التعديل (للعودة للحالة الأصلية)
                    cancelEdit(key);
                }
            });
        }
    </script>
