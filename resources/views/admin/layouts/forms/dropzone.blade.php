<script>
    Dropzone.autoDiscover = false;

    let previewTemplate = `
        <div class="dz-preview dz-file-preview">
            <div class="dz-photo">
                <img class="dz-thumbnail" data-dz-thumbnail />
            </div>
            <button class="dz-delete border-0 p-0" type="button" data-dz-remove>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#FFFFFF"
                        d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z">
                    </path>
                </svg>
            </button>
        </div>`;
    
    // تحديد العناصر الأساسية
    const dropzoneElement = document.getElementById('myDropzoneArea');
    const $existingPathInput = $('#existingImageHiddenInput'); // الحقل المخفي لمسار الصورة القديمة
    const $hiddenFileInput = $('#hiddenImageInput');             // حقل input type="file"
    const existingImageUrl = dropzoneElement ? dropzoneElement.dataset.existingImageUrl : null;
    
    // تأكد من تعريف رسالة الخطأ المطلوبة
    const requiredErrorMessage = '{{ __("site.image_is_required") }}';

    let myDropzone = new Dropzone("#myDropzoneArea", {
        url: "/",
        autoProcessQueue: false,
        uploadMultiple: false,
        maxFiles: 1,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        previewTemplate: previewTemplate,
        addRemoveLinks: true,
        dictDefaultMessage: "Drop files here or click to upload",
        
        // حفظ الحالة الأصلية لـ required
        originalRequired: $hiddenFileInput.prop('required'), 

        init: function() {
            const dz = this;

            // 1. إضافة الصورة القديمة كـ Mock File
            if (existingImageUrl) {
                const mockFile = {
                    name: "Current Image",
                    size: 123456,
                    type: "image/jpeg",
                    isExisting: true // لتمييزه كملف قديم
                };
                dz.emit("addedfile", mockFile);
                dz.emit("thumbnail", mockFile, existingImageUrl);
                dz.emit("complete", mockFile);
                dz.files.push(mockFile);
            }

            // 2. عند إضافة ملف جديد
            this.on("addedfile", function(file) {
                // إذا كان الملف المضاف جديداً (وليس mockFile)
                if (!file.isExisting) { 
                    
                    // 🔥🔥 FIX 1: حذف الملف الوهمي القديم إذا وجد قبل إضافة الجديد
                    const existingMockFile = this.files.find(f => f.isExisting);
                    if (existingMockFile) {
                        // استخدام removeFile سيطلق حدث removedfile تلقائياً، والذي سيهتم
                        // بمسح الـ $existingPathInput وتفعيل الـ required إذا لزم الأمر.
                        this.removeFile(existingMockFile); 
                    }
                    
                    // إزالة المسار القديم وإلغاء required (للتأكيد فقط، يتم هذا في removedfile أيضاً)
                    $existingPathInput.val(''); 
                    $hiddenFileInput.prop('required', false);
                    
                    // إزالة حالة الخطأ وجعل الحقل صالحاً
                    $hiddenFileInput[0].setCustomValidity(''); 
                    $(dropzoneElement).removeClass('is-invalid'); 

                    // ربط الملف الجديد بـ input type="file"
                    let dataTransfer = new DataTransfer();
                    this.files.filter(f => !f.isExisting).forEach(f => dataTransfer.items.add(f));
                    $hiddenFileInput[0].files = dataTransfer.files;
                }
            });


            // 3. 🔥 عند حذف ملف 🔥
            this.on("removedfile", function(file) {
                // مسح محتويات حقل input type="file"
                $hiddenFileInput.val("");
                $hiddenFileInput[0].files = new DataTransfer().files; 
                
                // إذا كان الملف المحذوف هو الصورة القديمة (Mock File)
                if (file.isExisting) {
                    // مسح قيمة الحقل المخفي للمسار القديم 
                    $existingPathInput.val(''); 
                    
                    // جعل الـ Field مطلوباً مرة أخرى
                    if (dz.options.originalRequired) {
                         $hiddenFileInput.prop('required', true); 
                         
                         // إجبار المتصفح على تفعيل التحقق (لإيقاف الإرسال)
                         $hiddenFileInput[0].setCustomValidity(requiredErrorMessage);
                         $(dropzoneElement).addClass('is-invalid');
                    }
                } 
            });
            
            // 4. 🔥🔥 FIX 2: معالجة تجاوز الحد الأقصى بشكل بسيط وآمن 🔥🔥
            this.on("maxfilesexceeded", function(file) {
                // بما أننا نعالج حذف الملف القديم في addedfile، هنا سنضمن
                // فقط أن الملف الجديد سيحل محل أي ملف حالي (قد يكون ملفاً جديداً أضيف سابقاً).
                //Dropzone سيحاول الآن إضافة الملف الجديد، وسيتم معالجته بواسطة addedfile
                 this.removeAllFiles();
                 this.addFile(file);
            });

        }
    });

    /**
     * Form on submit
     */
    $('#formSubmit').on('click', function(event) {
        event.preventDefault();
        var $this = $(this);
        const $form = $('#formDropzone');
        
        $this.children('.spinner-border').removeClass('d-none');

        // التحقق من Custom Validity قبل checkValidity
        if ($hiddenFileInput.prop('required') && $hiddenFileInput[0].checkValidity() === false) {
             // إذا كان مطلوباً وغير صالح، نوقف الإرسال
             event.stopPropagation();
             $form.addClass('was-validated');
             $this.children('.spinner-border').addClass('d-none');
             return;
        }

        // التحقق من الـ validation العادي للنموذج
        if ($form[0].checkValidity() === false) {
            event.stopPropagation();
            $form.addClass('was-validated');
            $this.children('.spinner-border').addClass('d-none');
        } else {
            
            const hasNewFile = myDropzone.files.filter(f => !f.isExisting).length > 0;
            
            if (hasNewFile) {
                 myDropzone.processQueue();
            } else {
                 // لا ملفات جديدة، أرسل النموذج فوراً
                 $form.submit(); 
            }
        }
    });
</script>