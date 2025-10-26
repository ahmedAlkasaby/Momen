<tr id="setting-row-{{ $setting->key }}" data-type="{{ $setting->type }}">
    <td><span class="badge bg-label-primary me-1">{{ __('site.' . $setting->group) }}</span></td>
    <td><strong>{{ __('site.' . $setting->key) }}</strong></td>

    <td>
        {{-- القيمة الحالية (هذا العنصر سيتم استبداله بحقل إدخال عند التعديل) --}}
        <span id="value-span-{{ $setting->key }}" data-original-value="{{ $setting->value }}"
            class="setting-value-display">

            @if ($setting->type === 'file' && $setting->value)
                {{-- عرض الصورة وتجهيزها للتكبير --}}
                <img src="{{ asset($setting->value) }}" onclick="viewImage('{{ asset($setting->value) }}')"
                    onerror="this.onerror=null;this.src='//:0'" class="clickable-image"
                    style="max-width: 80px; max-height: 80px; cursor: pointer; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @else
                {{-- عرض القيمة النصية أو الرقمية --}}
                {{ $setting->value }}
            @endif

        </span>
    </td>

    <td>
        {{-- الأزرار --}}
        <button id="edit-btn-{{ $setting->key }}" class="btn btn-sm btn-icon btn-outline-primary"
            onclick="enableEdit('{{ $setting->key }}')" title="{{ __('site.edit') }}">
            <i class="ti ti-edit"></i>
        </button>
        <button id="save-btn-{{ $setting->key }}" class="btn btn-sm btn-icon btn-success"
            onclick="saveSetting('{{ $setting->key }}')" title="{{ __('site.save') }}" style="display: none;">
            <i class="ti ti-check"></i>
        </button>
        <button id="cancel-btn-{{ $setting->key }}" class="btn btn-sm btn-icon btn-secondary"
            onclick="cancelEdit('{{ $setting->key }}')" title="{{ __('site.cancel') }}" style="display: none;">
            <i class="ti ti-x"></i>
        </button>
    </td>
</tr>
