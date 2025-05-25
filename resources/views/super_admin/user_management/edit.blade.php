@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')
    @include('flash::message')

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 text-end">
                    <a class="btn btn-sm btn-primary" href="{{ route('user.management.index') }}">{{ __("User List") }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.management.update', $user->id ?? 0) }}">
                @csrf
                <div class="row mb-4">
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name ?? '' }}" />
                        </div>
                    </div>
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input type="text" name="email" class="form-control" value="{{ $user->email ?? '' }}" readonly />
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="status">{{ __('Status') }}</label>
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option>{{ __('Select Status') }}</option>
                                @foreach($user_status as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $user->status ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
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
