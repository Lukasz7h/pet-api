<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePetForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    private $availableStatus = ['available', 'pending', 'sold'];

    public function checkUrl(string $photoUrls): string
    {
        $urls = explode(',', $photoUrls);
        $urls = array_filter($urls, fn($url) => strlen($url) > 0 && filter_var(trim($url), FILTER_VALIDATE_URL));

        return implode(',', $urls);
    }

    public function authorize(): bool
    {
        // Check if status property possess acceptable value
        $status = strtolower( $this->input('status') );
        if(isset($status) && !in_array($status, $this->availableStatus)) return false;

        // Check if property with photo's urls got impermissible values
        $photoUrls = $this['photoUrls'];
        if(isset($photoUrls) && strlen($photoUrls) > 0){
            $urls = $this->checkUrl($photoUrls);
            $this->merge(['photoUrls' => $urls]);
        }

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
            'id' => 'required|integer|min:1|digits_between:1,99999999999999999999'
        ];
    }

    public function messages()
    {
        return [
            'id.integer' => 'The ID must be an integer.',
            'id.min' => 'The ID must be between 1 and 99999999999999999999 digits.',
            'id.digits_between' => 'The ID must be between 1 and 99999999999999999999 digits.'
        ];
    }
}
