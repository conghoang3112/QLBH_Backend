<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends BaseRequest
{
    /**
     * Available relations to retrieve
     * @var string[]
     */
    protected array $relations = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:100', 'unique:roles,slug,' . $this->id],
            'name' => ['required', 'string', 'max:100'],
        ];
    }
}