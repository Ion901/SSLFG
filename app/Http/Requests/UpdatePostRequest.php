<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
        return
            $rules = [
                'category' => 'string',
                'photo.*'  => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'content'  => 'string',
                'title'    => 'string',
            ];

        if ($this->has('category') && $this->category === 'SPORT') {
            $rules += [
                'competition_name'     => 'string',
                'competition_location' => 'string',
                'competition_date'     => 'date',
            ];
        }

        return $rules;
    }
}
