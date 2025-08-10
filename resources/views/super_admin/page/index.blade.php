@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i> {{ __('Page list') }}
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('page.add') }}">
                {{ __('Add') }} <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-striped table-bordered nowrap w-100">
                    <thead>
                    <tr>
                        <th>{{ __('action') }}</th>
                        <th>{{ __('Menu') }}</th>
                        <th>{{ __('Sub Menu') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Display Name') }}</th>
                        <th>{{ __('Method Name') }}</th>
                        <th>{{ __('Created At') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            const editUrlTemplate = @json(route('page.edit', ':id'));
            const deleteUrlTemplate = @json(route('page.delete', ':id'));
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,          // Enables horizontal scrolling
                autoWidth: false,       // Disables DataTables' auto column width guesswork
                ajax: '{{ route("page.index") }}',
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
                    { data: 'menu_id' },
                    { data: 'sub_menu_id' },
                    { data: 'name' },
                    { data: 'display_name' },
                    { data: 'method_name' },
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
@push('styles')
    <style>
        #users-table {
            table-layout: auto !important;
        }
    </style>
@endpush
