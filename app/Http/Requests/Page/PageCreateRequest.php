<?php

namespace App\Http\Requests\Page;

use App\Rules\PageUrlRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PageCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page_url' => ['required', 'url', new PageUrlRule()],
            'email' => ['required', 'email'],
        ];
    }
}
