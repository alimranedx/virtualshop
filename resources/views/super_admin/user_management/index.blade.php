@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> {{ __('User Data list') }}
        </div>
        <div class="card-body">
            <table id="users-table" class="display">
                <thead>
                <tr>
                    <th>action</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>{{ __('User Type') }}</th>
                    <th>{{ __('Created At') }}</th>
                </tr>
                </thead>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
{{--                {{ $users->links() }}--}}
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            const editUrlTemplate = @json(route('user.management.edit', ':id'));
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("user.management.index") }}',
                columns: [
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            const editUrl = editUrlTemplate.replace(':id', data);
                            return `<a class="btn btn-sm btn-primary" href="${editUrl}">{{ __("Edit") }}</a>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'user_type' },
                    { data: 'created_at' }
                ]
            });
        });
    </script>
@endsection
