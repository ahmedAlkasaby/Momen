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


@section('jsFiles')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    @include('admin.layouts.table.dataTableJs', ['table' => $settings->count() > 0])
    @include('admin.settings.includes.update_settings')

@endsection
