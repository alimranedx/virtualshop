<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class UserRoleManagement extends Model
{
    protected $guarded = [];
    protected $table = 'user_role_management';
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
    public function insertData($data)
    {
        return self::query()->insert($data);
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
    public function getByRoleId($role_id)
    {
        return self::query()->where('role_id', $role_id)->get();
    }
    public function deleteByRoleId($role_id)
    {
        return self::query()->where('role_id', $role_id)->delete();
    }
    public function getByFilters($search)
    {

    }
}
