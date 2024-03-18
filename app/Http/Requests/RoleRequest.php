<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
{
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
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required' , 'string' , 'max:225'],
            'permission' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'الإسم',
            'permission' => 'الأذونات'
        ];
    }

    public function store()
    {
        $role = Role::create(['name' => $this->get('name')]);
        $role->syncPermissions($this->get('permission'));
    }

    public function update($role)
    {
        $role->update($this->only('name'));
    
        $role->syncPermissions($this->get('permission'));
    }
}
