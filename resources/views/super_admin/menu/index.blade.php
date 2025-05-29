@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i> {{ __('Menu list') }}
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('menu.add') }}">
                {{ __('Add') }} <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-body">
            <table id="users-table" class="display">
                <thead>
                <tr>
                    <th>{{ __('action') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Display Name') }}</th>
                    <th>{{ __('Order') }}</th>
                    <th>{{ __('Order') }}</th>
                    <th>{{ __('Icon') }}</th>
                </tr>
                </thead>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
{{--                {{ $menus->links() }}--}}
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            const editUrlTemplate = @json(route('menu.edit', ':id'));
            const deleteUrlTemplate = @json(route('menu.delete', ':id'));
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("menu.index") }}',
                columns: [
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            const editUrl = editUrlTemplate.replace(':id', data);
                            const deleteUrl = deleteUrlTemplate.replace(':id', data);
                            return `
                            <a class="btn btn-sm btn-primary" href="${editUrl}">{{ __("Edit") }}</a>
                            <a href="${deleteUrl}" class="btn btn-sm btn-danger" onclick="confirmDelete(event, '${deleteUrl}')">
                                {{ __('Delete') }}
                            </a>
`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name' },
                    { data: 'display_name' },
                    { data: 'order' },
                    { data: 'icon' },
                    { data: 'created_at' }
                ]
            });

        });
        function confirmDelete(event, url) {
            event.preventDefault(); // Prevent default link click

            alertify.confirm(
                'Confirm Deletion',
                'Are you sure you want to delete this item?',
                function() {
                    window.location.href = url;
                },
                function() {
                    alertify.error('Deletion cancelled');
                }
            ).set('labels', {ok:'Yes', cancel:'No'}).set('closable', false);
        }
    </script>
@endsection
