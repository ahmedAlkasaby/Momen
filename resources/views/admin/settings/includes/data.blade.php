<tr>
    {{-- Key/اسم الإعداد --}}
    <td>
        <strong>{{ $setting->key }}</strong> 
        {{-- افترضنا أن لديك ملف ترجمة وأن المفتاح موجود فيه --}}
    </td>
    
    {{-- القيمة الحالية (هذا العنصر سيتم استبداله بحقل إدخال عند التعديل) --}}
    <td>
        <span id="value-span-{{ $setting->key }}">{{ $setting->value }}</span>
    </td>
    
    <td>
        <span >{{ $setting->group }}</span>
    </td>
    
    {{-- الأكشنز (الأزرار) --}}
    <td>
        {{-- زر التعديل (يظهر بشكل افتراضي) --}}
        <button 
            id="edit-btn-{{ $setting->key }}" 
            class="btn btn-sm btn-icon btn-outline-primary"
            onclick="enableEdit('{{ $setting->key }}')"
            title="{{ __('site.edit') }}"
        >
            <i class="ti ti-edit"></i>
        </button>

        {{-- زر الحفظ (يظهر عند التعديل) --}}
        <button 
            id="save-btn-{{ $setting->key }}" 
            class="btn btn-sm btn-icon btn-success"
            onclick="saveSetting('{{ $setting->key }}')"
            title="{{ __('site.save') }}"
            style="display: none;"
        >
            <i class="ti ti-check"></i>
        </button>

        {{-- زر الإلغاء (يظهر عند التعديل) --}}
        <button 
            id="cancel-btn-{{ $setting->key }}" 
            class="btn btn-sm btn-icon btn-secondary"
            onclick="cancelEdit('{{ $setting->key }}')"
            title="{{ __('site.cancel') }}"
            style="display: none;"
        >
            <i class="ti ti-x"></i>
        </button>
    </td>
</tr>