@php
    // 1. تحديد اسم الحقل والتحكم به
    $field_name = $select_name ?? 'active';
    
    // إذا كان الحقل متعدد، أضف [] إلى الاسم
    if (isset($is_multiple)) {
        $field_name .= '[]';
    }

    // 2. بناء خصائص التحكم (Attributes)
    $array_control = [
        'class' => 'form-select form-control',
        'style' => 'width: 100%',
        'data-parsley-trigger' => 'select',
        'name' => $field_name // إضافة اسم الحقل هنا لتمريره في الحلقة
    ];

    // إضافة الخصائص الاختيارية
    if (!empty($disable)) $array_control['disabled'] = 'disabled';
    if (!empty($read_only)) $array_control['readonly'] = 'readonly';
    if (!isset($not_req)) $array_control['required'] = '';
    
    // إضافة خاصية multiple
    if (isset($is_multiple)) {
        $array_control['multiple'] = 'multiple';
    }

    // إضافة select2 class
    if(isset($select2)) $array_control['class'] .= ' select2';

    // تحديد الـ ID والـ Class النهائي
    if (isset($select_id)) {
        $array_control['id'] = $select_id;
    } else {
        // ID فريد وآمن
        $array_control['id'] = str_replace(['[', ']'], ['-', ''], $field_name) . '_id'; 
    } 
    
    if (isset($select_class)) {
        $array_control['class'] = $select_class;
    } 

    // تحديد الـ Label
    $label_default = __("site." . str_replace('[]', '', $field_name));
    if(isset($label)){
        $label_default = $label;
    }

    // 3. معالجة القيمة المختارة (للحقول المتعددة)
    if (isset($is_multiple)) {
        // نضمن أن القيمة هي مصفوفة من السلاسل النصية للمقارنة الصحيحة
        $selected_values = is_array($select_value) ? $select_value : (array) $select_value;
        $selected_ids = array_map('strval', $selected_values);
    }
    
@endphp

@include('admin.layouts.forms.fields.form-group-head', ['field_name' => $field_name])
@include('admin.layouts.forms.fields.label',['label_default'=>$label_default])

@if (isset($is_multiple))
    
    {{-- 🌟 بناء HTML خام لحقل Multi-select: تم استبدال html_attributes() بالطباعة اليدوية --}}
    <select 
        @foreach ($array_control as $key => $value)
            {{-- طباعة الخصائص: إذا كانت القيمة موجودة، اطبع الخاصية=القيمة. إذا كانت الخاصية بدون قيمة (مثل multiple)، اطبعها فقط --}}
            @if ($value !== false && $value !== null && $value !== '')
                {{ $key }}="{{ $value }}"
            @elseif ($key === 'required' || $key === 'multiple' || $key === 'disabled' || $key === 'readonly')
                {{ $key }}
            @endif
        @endforeach
    >
        
        @foreach ($select_function as $key => $value)
            
            {{-- نتجنب الخيارات ذات القيمة الفارغة (مثل "اختر") في حقل Multi-select --}}
            @if ($key !== "" && $key !== null) 
                
                @php
                    $current_id_string = (string) $key;
                @endphp
                
                <option value="{{ $key }}"
                    {{-- منطق تحديد الخيار (Selection Logic) --}}
                    @if(in_array($current_id_string, $selected_ids)) 
                        selected 
                    @endif
                >
                    {{ $value }}
                </option>
                
            @endif
            
        @endforeach
        
    </select>
    
@else
    
    {{-- 💎 استخدام مكتبة النماذج للحقول العادية (غير المتعددة) --}}
    {{ html()->select($field_name, $select_function ?? booleanType(), $select_value ?? null)->attributes($array_control) }}

@endif

@include('admin.layouts.forms.fields.form-group-foot', ['field_name' => $field_name])