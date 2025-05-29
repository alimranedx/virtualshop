@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')
    @include('flash::message')

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 text-end">
                    <a class="btn btn-sm btn-primary" href="{{ route('sub.menu.index') }}">{{ __("Sub Menu List") }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sub.menu.add') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="menu_id">{{ __('Menu') }}</label>
                            <select name="menu_id" class="form-select" aria-label="Default select example">
                                <option >{{ __('Menu Select') }}</option>
                                @foreach($menu as $data)
                                    <option {{ old('menu_id') ==  $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ __($data->display_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" value=" {{ old('name') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="display_name">{{ __('Display Name') }}</label>
                            <input type="text" name="display_name" class="form-control" value=" {{ old('display_name') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="controller_name">{{ __('Controller Name') }}</label>
                            <input type="text" name="controller_name" class="form-control" value="{{ old('controller_name') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="method_name">{{ __('Method Name') }}</label>
                            <input type="text" name="method_name" class="form-control" value="{{ old('method_name') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="order">{{ __('Order') }}</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="icon">{{ __('Icon') }}</label>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" />
                        </div>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="text-end">
                    <button  type="submit" class="btn btn-primary btn-block mb-4">{{ __('Add') }}</button>
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
