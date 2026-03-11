<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $adminId = $this->route('admin'); // utile pour update

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($adminId),
            ],
            'password' => $this->isMethod('post') 
                ? 'required|string|min:8|confirmed' // create
                : 'nullable|string|min:8|confirmed', // update
        ];
    }
}
