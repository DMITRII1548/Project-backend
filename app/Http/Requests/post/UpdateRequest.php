<?php

namespace App\Http\Requests\post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        return [
            'title' => 'String',
            'body' => 'String',
            'userId' => 'Integer',
            'reactions' => 'Integer',
            'tags' => 'array',
        ];
    }
}
