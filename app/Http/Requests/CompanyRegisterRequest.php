<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Http\Response;
use App\Models\{User, Suburb, CompanyType};

class CompanyRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'suburb_id' => ['required', 'exists:' . Suburb::class . ',id'],
            'company_type_id' => ['required', 'exists:' . CompanyType::class . ',id'],
        ];
    }

    public function failedValidation(Validator $validator): Response
    {
        throw new HttpResponseException(Response([
            'success'   => false,
            'status' => 'error',
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
