<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserReqeust extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

        $rule = [
            'name' => 'required|min:3|max:100',
            'email' => ['required','min:3','max:100','email:rfc',Rule::unique('users', 'email')->ignore($this->user->id) ],
            'phone' => 'required|numeric|digits_between:9,12',
            'status' => 'required',
        ];

        if ($method == 'POST') {
            $rule += [
                'email' => ['required','min:3','max:100','email:rfc',Rule::unique('users', 'email')],
                'password' => 'required|min:3|max:20',
            ];
        }

        return $rule;
    }
}
