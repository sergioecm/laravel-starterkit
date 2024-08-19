<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreManagementUsersRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::debug(__METHOD__.' '.__LINE__.'  '.print_r('',true));
        $authorize= auth()->user()->can('users-create')?true:false;
        return $authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::debug(__METHOD__.' '.__LINE__.'  '.print_r('',true));
        return [
            'name' => 'required',
            "email" => 'required',
            "password" => 'required',
            "roles" => 'required'
        ];
    }
}
