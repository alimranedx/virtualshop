@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')
    @include('flash::message')

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 text-end">
                    <a class="btn btn-sm btn-primary" href="{{ route('page.index') }}">{{ __("Page List") }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('page.add') }}">
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
                            <label class="form-label" for="sub_menu_id">{{ __('Sub Menu') }}</label>
                            <select
                                id="sub_menu_id"
                                name="sub_menu_id"
                                class="form-select"
                                aria-label="Default select example"
                                onchange="changeSubMenu(this)"
                            >
                                <option >{{ __('Sub Menu Select') }}</option>
                                @foreach($subMenu as $data)
                                    <option {{ old('sub_menu_id') ==  $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ __($data->display_name) }}</option>
                                @endforeach
                            </select>
                            <p id="controller_div"> </p>
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
                            <label class="form-label" for="method_name">{{ __('Method Name') }}</label>
                            <input type="text" name="method_name" class="form-control" value="{{ old('method_name') }}" />
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
        const subMenuList = @json($subMenu);
        $(document).ready(function () {

        });
        function changeSubMenu(e){
            const sub_menu_id = parseInt(e.value);
            const selectedSubMenu = subMenuList.find(item => item.id === sub_menu_id);
            let controller_name = '';
            if (!isEmpty(selectedSubMenu)) {
                 controller_name = selectedSubMenu.controller_name
            }
            if(!isEmpty(controller_name)){
                $('#controller_div').html('Controller name is '+controller_name);
            }else{
                $('#controller_div').html('');
            }

        }
    </script>
@endsection
