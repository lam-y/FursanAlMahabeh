@php
    $field['value'] = $field['value'] ?? 0;
@endphp

<div class="form-group col-md-12">
    <label>{!! $field['label'] !!}</label>
    <br>
    <input type="checkbox"
           name="{{ $field['name'] }}"
           data-toggle="toggle"
           data-on="Active"
           data-off="Inactive"
           value="1"
           @if(old($field['name'], $field['value'])) checked @endif
    >
</div>

@push('crud_fields_scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
@endpush

@push('crud_fields_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-toggle/css/bootstrap-toggle.min.css">
@endpush
