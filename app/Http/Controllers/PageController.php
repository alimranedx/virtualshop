<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\SubMenu;
use Common\Services\PageService;
use Common\Services\SubMenuService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = __('Page');
        $data['sub_title'] = __('list');
        if($request->ajax()){
            $search_params['data_table'] = true;
            return (new Page())->getAllData($search_params)->getData();
        }
        return view('super_admin.page.index', $data);
    }
    public function add(Request $request)
    {
        $data['title'] = __('Page');
        $data['sub_title'] = __('Add');
        $is_post_method = $request->isMethod('POST');
        list($status_code, $status_message, $label, $data) = (new PageService())->addSubMenu($request->all(), $data, $is_post_method);
        if($is_post_method){
            flash(__($status_message))->$label();
            return redirect()->back()->withInput();
        }
        return view('super_admin.page.add', $data);
    }
    public function edit($id)
    {
        $data['title'] = __('Page');
        $data['sub_title'] = __('edit');
        $data = (new PageService())->getEditData($id,$data);
        return view('super_admin.page.edit', $data);
    }
    public function update(Request $request, $id)
    {
        list($status_code, $status_message, $label) = (new PageService())->updatePage($id, $request->all());
        flash(__($status_message))->$label();
        return redirect()->back();
    }
    public function delete($id)
    {
        list($status_code, $status_message, $label) = (new PageService())->deletePage($id);
        flash(__($status_message))->$label();
        return redirect()->back();
    }
}
