@extends('layouts.super_admin_app')
@section('content')
    @include('common.breadcrumb')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i> {{ __('Role Page list') }}
            </div>

        </div>
        <div class="card-body">
            <div class="card-body">
                <form method="POST" action="{{ route('page.add') }}">
                    @csrf
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th>Submenu</th>
                            <th>Pages</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menu as $menu_data)
                            @php
                                // All submenus under this menu
                                $menuSubmenus = $subMenu->where('menu_id', $menu_data->id);

                                // Count total rows this menu will span (sum of each submenu's pages or 1 if no pages)
                                $menuRowCount = $menuSubmenus->sum(fn($sm) => max($page->where('sub_menu_id', $sm->id)->count(), 1)) ?: 1;

                                $firstMenuRow = true;
                            @endphp

                            @foreach($menuSubmenus->count() ? $menuSubmenus : [null] as $submenu_data)
                                @php
                                    // All pages under this submenu
                                    $submenuPages = $submenu_data ? $page->where('sub_menu_id', $submenu_data->id) : collect();

                                    // Count rows this submenu will span
                                    $submenuRowCount = max($submenuPages->count(), 1);

                                    $firstSubmenuRow = true;
                                @endphp

                                @foreach($submenuPages->count() ? $submenuPages : [null] as $page_data)
                                    <tr>
                                        {{-- MENU cell only once --}}
                                        @if($firstMenuRow)
                                            <td rowspan="{{ $menuRowCount }}" class="align-middle fw-bold">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input menu-checkbox" id="menu_{{ $menu_data->id }}">
                                                    <label class="form-check-label" for="menu_{{ $menu_data->id }}">
                                                        {{ $menu_data->display_name }}
                                                    </label>
                                                </div>
                                            </td>
                                            @php $firstMenuRow = false; @endphp
                                        @endif

                                        {{-- SUBMENU cell only once --}}
                                        @if($firstSubmenuRow)
                                            <td rowspan="{{ $submenuRowCount }}" class="align-middle">
                                                @if($submenu_data)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input submenu-checkbox"
                                                               data-menu="{{ $menu_data->id }}"
                                                               id="submenu_{{ $submenu_data->id }}">
                                                        <label class="form-check-label" for="submenu_{{ $submenu_data->id }}">
                                                            {{ $submenu_data->display_name }}
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            @php $firstSubmenuRow = false; @endphp
                                        @endif

                                        {{-- PAGE cell --}}
                                        <td>
                                            @if($page_data)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input page-checkbox"
                                                           data-submenu="{{ $submenu_data->id ?? '' }}"
                                                           id="page_{{ $page_data->id }}">
                                                    <label class="form-check-label" for="page_{{ $page_data->id }}">
                                                        {{ $page_data->display_name }}
                                                    </label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>




                    <!-- Submit button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-block mb-4">{{ __('Add') }}</button>
                        </div>
                </form>

            </div>
        </div>
    </div>

@endsection
@section('script')
        <script>
            $(document).ready(function () {
                // Page → Submenu
                $('.page-checkbox').on('change', function () {
                    let submenuId = $(this).data('submenu');
                    let allPages = $(`.page-checkbox[data-submenu="${submenuId}"]`).length;
                    let checkedPages = $(`.page-checkbox[data-submenu="${submenuId}"]:checked`).length;
                    $(`#submenu_${submenuId}`).prop('checked', allPages === checkedPages).trigger('change');
                });

                // Submenu → Menu
                $('.submenu-checkbox').on('change', function () {
                    let submenuId = $(this).val();
                    let menuId = $(this).data('menu');
                    $(`.page-checkbox[data-submenu="${submenuId}"]`).prop('checked', $(this).is(':checked'));
                    let allSubmenus = $(`.submenu-checkbox[data-menu="${menuId}"]`).length;
                    let checkedSubmenus = $(`.submenu-checkbox[data-menu="${menuId}"]:checked`).length;
                    $(`#menu_${menuId}`).prop('checked', allSubmenus === checkedSubmenus);
                });

                // Menu → All submenus & pages
                $('.menu-checkbox').on('change', function () {
                    let menuId = $(this).val();
                    let isChecked = $(this).is(':checked');
                    $(`.submenu-checkbox[data-menu="${menuId}"]`)
                        .prop('checked', isChecked)
                        .trigger('change');
                });
            });



        </script>
@endsection
@push('styles')
    <style>
        #users-table {
            table-layout: auto !important;
        }
    </style>
@endpush
