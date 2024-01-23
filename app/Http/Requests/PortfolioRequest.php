<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
            'title' => ['string', 'max:255'],
            'description' => ['string', 'max:1200'],
            'url' => ['string', 'max:255'],
            'start_date' => ['date'],
            'end_date' => ['date'],
            'skill_used' => ['string', 'max:500'],
            'images' => ['string', 'max:191'],
            'video_links' => ['string', 'max:255'],
        ];
    }
}
