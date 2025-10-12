@php
$add_class = '';
if (isset($text_class)) {
$add_class = $text_class;
}
$field_name = 'password';
if (isset($text_name)) {
$field_name = $text_name;
}
$array_control = ['class' => 'form-control' . $add_class, 'data-parsley-minlength' => $minlength ?? '8',
'data-parsley-trigger' => 'input', ];
if (!empty($disable)) $array_control['disabled'] = 'disabled';
if (!empty($read_only)) $array_control['readonly'] = 'readonly';
if (!isset($not_req)) {
$array_control['required'] = '';
}
if (isset($text_id)) {
$array_control['id'] = $text_id;
}
if (isset($equalto)) {
$array_control['data-parsley-equalto'] = $equalto;
}
@endphp
@include('admin.layouts.forms.fields.form-group-head', ['field_name' => $field_name])
@if (!isset($label_show))
<label>{{ $label_name ?? __('Password') }}</label>
@endif
{{ html()->password($field_name)->attributes($array_control) }}
@include('admin.layouts.forms.fields.form-group-foot', ['field_name' => $field_name])