<?php

namespace Modules\Member\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $member = $this->route('member');

        return [
            'nama'   => 'required|string|max:255',
            'email'  => [
                'required',
                'email',
                Rule::unique('members', 'email')->ignore($member?->id), // ini solusi kuncinya
            ],
            'alamat' => 'required|string|max:255',
        ];
    }


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
