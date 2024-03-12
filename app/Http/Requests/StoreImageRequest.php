<?php

namespace App\Http\Requests;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreImageRequest extends FormRequest
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
            'images' => ['required', 'max:5'],
            'images.*' => [
                'required',
                'image',
                function ($attribute, $value) {
                    $image_name = Str::slug(pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME)) .
                        '.' . $value->getClientOriginalExtension();

                    $image_exists = Image::query()->where('filename', $image_name)
                        ->exists();

                    $value->imageName = $image_exists ?
                        Str::random(strlen($image_name)) . '.' . $value->getClientOriginalExtension() :
                        $image_name;
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'images.max' => 'Only 5 images are allowed at a time',
        ];
    }
}
