<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPetForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    private $maxNumberID = 9999999999999;
    private $maxNameLen = 30;

    private $availableStatus = ['available', 'pending', 'sold'];
    private $errorMessages;

    public function __construct()
    {
        // Budujemy tablicę komunikatów z dynamicznymi wartościami
        $this->errorMessages = [
            'id.value' => "The ID must be a value between 1 and {$this->maxNumberID}.",
            'category.id.value' => "The category ID must be a value between 1 and {$this->maxNumberID}.",
            'category.name.length' => "The category name should be between 1 and {$this->maxNameLen} characters.",
            'name.length' => "The name should be between 3 and {$this->maxNameLen} characters.",
            'tag.id.value' => "The tag ID must be a value between 1 and {$this->maxNumberID}.",
            'tag.name.length' => "The tag name should be between 1 and {$this->maxNameLen} characters."
        ];
    }

    public function checkUrl(string $photoUrls): string
    {
        $urls = explode(',', $photoUrls);
        $urls = array_filter($urls, fn($url) => strlen($url) > 0 && filter_var(trim($url), FILTER_VALIDATE_URL));

        return implode(',', $urls);
    }

    public function authorize(): bool
    {
        $status = strtolower( $this->input('status') );
        if(!in_array($status, $this->availableStatus)) return false;

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
        $maxNumberID = $this->maxNumberID;
        $maxNameLen = $this->maxNameLen;
        return [
            'id' => "required|integer|min:1|max:$maxNumberID",
            'category.0.id' => "required|integer|min:1|max:$maxNumberID",
            'category.0.name' => "required|string|min:3|max:$maxNameLen",
            'name' => "required|string|min:3|max:$maxNameLen",
            'photoUrls' => "nullable|string|max:500",
            'tags.0.id' => "required|integer|min:1|max:$maxNumberID",
            'tags.0.name' => "required|string|min:3|max:$maxNameLen",
            'status' => 'required|string'
        ];
    }

    public function messages()
    {
        $errors = $this->errorMessages;

        return [
            'id.integer' => 'The ID must be an integer.',
            'id.max' => $errors['id.value'],
            'id.min' => $errors['id.value'],
            'category.0.id.integer' => 'The category ID must be an integer.',
            'category.0.id.min' => $errors['category.id.value'],
            'category.0.id.max' => $errors['category.id.value'],
            'category.0.name.max' => $errors['category.name.length'],
            'category.0.name.min' => $errors['category.name.length'],
            'name.max' => $errors['name.length'],
            'name.min' => $errors['name.length'],
            'photoUrls.max' => 'The photos URLs may not be greater than 500 characters.',
            'tags.0.id.integer' => 'The tag ID must be an integer.',
            'tags.0.id.min' => $errors['tag.id.value'],
            'tags.0.id.max' => $errors['tag.id.value'],
            'tags.0.name.max' => $errors['tag.name.length'],
            'tags.0.name.min' => $errors['tag.name.length'],
            'status.max' => 'The status may not be greater than 9 characters.', // 9 because longest word from established words span got that
        ];
    }
}
