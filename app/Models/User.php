<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Yajra\DataTables\DataTables;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //user type constants  goes there 1=>super_admin , 2=>admin, 3=>manager
    const USER_TYPE_SUPER_ADMIN = 1;
    const USER_TYPE_ADMIN = 2;
    const USER_TYPE_MANAGER = 3;
    const USER_TYPE_USER = 4;
    const USER_TYPES = [self::USER_TYPE_SUPER_ADMIN, self::USER_TYPE_ADMIN, self::USER_TYPE_MANAGER, self::USER_TYPE_USER];
    const USER_TYPE_TEXT = [
        self::USER_TYPE_SUPER_ADMIN => 'Super Admin',
        self::USER_TYPE_ADMIN => 'Admin',
        self::USER_TYPE_MANAGER => 'Manager',
        self::USER_TYPE_USER => 'User'
    ];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const USER_TYPE_UNKNOWN = 'unknown_user';
    const DEFAULT_PAGINATION_PAGE_LIMIT = 10;

    const USER_STATUS = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getAllUsers($search_params = [])
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
    public function getById($id)
    {
        return self::query()->where('id', $id)->first();
    }
    public function updateUserById($id, $data)
    {
        return self::query()->where('id', $id)->update($data);
    }
}
