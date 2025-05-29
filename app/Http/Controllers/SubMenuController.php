<?php

namespace App\Http\Controllers;

use App\Models\SubMenu;
use Common\Services\SubMenuService;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('SubMenu');
        $data['sub_title'] = __('list');
        if($request->ajax()){
            $search_params['data_table'] = true;
            return (new SubMenu())->getAllData($search_params)->getData();
        }
        return view('super_admin.sub_menu.index', $data);
    }
    public function add(Request $request)
    {
        $data['title'] = __('SubMenu');
        $data['sub_title'] = __('Add');
        $is_post_method = $request->isMethod('POST');
        list($status_code, $status_message, $label, $data) = (new SubMenuService())->addSubMenu($request->all(), $data, $is_post_method);
        if($is_post_method){
            flash(__($status_message))->$label();
            return redirect()->back()->withInput();
        }
        return view('super_admin.sub_menu.add', $data);
    }
    public function edit($id)
    {
        $data['title'] = __('SubMenu');
        $data['sub_title'] = __('edit');
        $data = (new SubMenuService())->getEditData($id,$data);
        return view('super_admin.sub_menu.edit', $data);
    }
    public function update(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new SubMenuService())->updateSubMenu($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function delete($id)
    {
        list($status_code, $status_message, $label) = (new SubMenuService())->deleteSubMenu($id);
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
