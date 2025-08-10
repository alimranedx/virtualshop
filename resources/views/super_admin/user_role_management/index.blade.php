@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')
    @include('flash::message')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i> {{ __('Role list && User List') }}
            </div>

        </div>
        <div class="card-body">
            <form action="{{ route('user.role.save') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="role">{{ __('Roles') }}</label>
                        <select class="selectpicker form-control" id="role" name="role"
                                data-live-search="true"
                                data-actions-box="true"
                                data-selected-text-format="count > 3"
                                title="{{ __('Select ...') }}"
                                onchange="selectUsers(this)"
                                required
                                >
                            @foreach($roleData as $data)
                                <option value="{{ $data->id }}" >{{ __($data->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-4 ps-4" id="users_div">
                            @foreach($userData as $data)
                            <div class="py-2 px-3">
                                <input type="checkbox" id="user{{$data->id}}" name="users[]" value="{{ $data->id }}">
                                <label class="px-4" for="user{{$data->id}}">{{ __($data->name) }}</label>
                            </div>
                            @endforeach

                        </div>

                    </div>

                </div>
                <div class="text-center">
                    <br>
                    <input class="btn btn-success" type="submit" value="{{ __('Save User Role') }}">
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')

    <script>

        $(document).ready(function(){
            $('#user_common_div').hide();
            let roleId = $('#role').val();

        });

        function selectUsers(e) {
            $('#users_div input[type="checkbox"]').prop('checked', false);
            const roleId = e.value;
            if(!isEmpty(roleId)){
                $.ajax({
                    url: "{{ route('user.role.index') }}",
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        action  : 'get_role_wise_users',
                        role_id : roleId
                    },
                    success: function (response) {
                        let userIds = response.user_ids;
                        userIds.forEach(function (uId){
                            $('#user'+uId).prop('checked', true);
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseJSON || xhr.responseText);
                    }
                });
            }
        }


        // success: function(response) {
        //     let $select = $('#users');
        //     $select.empty();
        //     response.forEach(function(user) {
        //         $select.append(`<option value="${user.id}">${user.name}</option>`);
        //     });
        //     $select.selectpicker('refresh');
        // }

    </script>
@endsection
@push('styles')
    <style>
        #users-table {
            table-layout: auto !important;
        }
    </style>
@endpush
