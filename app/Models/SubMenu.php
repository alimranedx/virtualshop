<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class SubMenu extends Model
{
    protected $guarded = [];
    protected $table = 'sub_menu';
    const DEFAULT_PAGINATION_PAGE_LIMIT = 10;
    public function getAllData($search_params = [])
    {
        $query = self::query();
        if(!empty($search_params)){
            if(!empty($search_params['paginate'])){
                $limit = $search_params['limit'] ?? self::DEFAULT_PAGINATION_PAGE_LIMIT;
                $query = $query->paginate($limit);
            }
            if(!empty($search_params['data_table'])){
                $query = DataTables::of($query)->make(true);
            }
        }else{
            $query = $query->get();
        }
        return $query;
    }
    public function createSubMenu($data)
    {
        return self::query()->create($data);
    }
    public function getById($id)
    {
        return self::query()->where('id', $id)->first();
    }
    public function updateById($id, $data)
    {
        return self::query()->where('id', $id)->update($data);
    }
    public function deleteById($id)
    {
        return self::query()->where('id', $id)->delete();
    }
}
