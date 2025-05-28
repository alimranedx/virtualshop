@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')
    @include('flash::message')

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 text-end">
                    <a class="btn btn-sm btn-primary" href="{{ route('permission.index') }}">{{ __("Permission List") }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('permission.update', $permission->id ?? 0) }}">
                @csrf
                <input type="hidden" name="type" value="{{ \App\Models\User::USER_TYPE_ADMIN }}">
                <div class="row mb-4">
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ $permission->name ?? '' }}" />
                        </div>
                    </div>
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="display_name">{{ __('Display Name') }}</label>
                            <input type="text" name="display_name" class="form-control" value="{{ $permission->display_name ?? '' }}" />
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <div class="text-end">
                    <button  type="submit" class="btn btn-primary btn-block mb-4">{{ __('Update') }}</button>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
