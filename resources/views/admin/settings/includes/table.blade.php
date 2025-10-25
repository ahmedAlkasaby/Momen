@include('admin.layouts.table.header', [
    'TitleTable' => __('site.settings'),
    'routeToCreate' => route('dashboard.settings.create'),
    'filter' => false,
    'issCreate' => false,
    "model" => "settings",
])

@include('admin.layouts.table.thead_info', [
    'columns' => [
        'site.key',
        'site.value',
        'site.group',
        'site.action',
    ],
])

<tbody>
    @if ($settings->count() > 0)
        @each('admin.settings.includes.data', $settings, 'setting')
    @else
        @include('admin.layouts.table.empty', [($number = 8)])
    @endif
</tbody>
</table>
@include('admin.layouts.table.footer')
@include('admin.layouts.table.paginate', ['data' => $settings])
