<?php

namespace App\DataResources\User;

use App\DataResources\BaseDataResource;
use App\DataResources\Company\CompanyResource;
use App\DataResources\Role\RoleResource;
use App\Models\User;

class UserResource extends BaseDataResource
{
    protected $role_id;
    /**
     * @var array|string[]
     */
    protected array $fields = [
        'id',
        'username',
        'fullName',
        'role_id',
    ];

    /**
     * Return the model class of this resource
     */
    public function modelClass(): string
    {
        return User::class;
    }

    /**
     * Load data for output
     * @param User $obj
     * @return void
     */
    public function load(mixed $obj): void
    {
        parent::copy($obj, $this->fields);

        if (in_array('role_id', $this->fields)) {
            $this->withField('role_id');
            $this->role_id = new RoleResource($obj->role);
        }

        // if (in_array('companies', $this->fields)) {
        //     $this->companies = BaseDataResource::generateResources($obj->companies, CompanyResource::class);
        // }
    }
}
