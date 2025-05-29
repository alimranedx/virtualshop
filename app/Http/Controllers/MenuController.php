<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Common\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('Menu');
        $data['sub_title'] = __('list');
        if($request->ajax()){
            $search_params['data_table'] = true;
            return (new Menu())->getAllData($search_params)->getData();
        }
        return view('super_admin.menu.index', $data);
    }
    public function add(Request $request)
    {
        $data['title'] = __('Menu');
        $data['sub_title'] = __('Add');
        if($request->isMethod('POST')){
            list($status_code, $status_message, $label) = (new MenuService())->addMenu($request->all());
            flash(__($status_message))->$label();
            return redirect()->back()->withInput();
        }
        return view('super_admin.menu.add', $data);
    }
    public function edit($id)
    {
        $data['title'] = __('Menu');
        $data['sub_title'] = __('edit');
        $data['menu'] = (new Menu())->getById($id);
        return view('super_admin.menu.edit', $data);
    }
    public function update(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new MenuService())->updateMenu($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function delete($id)
    {
        list($status_code, $status_message, $label) = (new MenuService())->deleteMenu($id);
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
