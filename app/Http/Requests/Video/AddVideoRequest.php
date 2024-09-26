<?php

namespace App\Http\Requests\Video;

use App\Enums\VideoTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddVideoRequest extends FormRequest
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
            'secondary_section_id' => [Rule::exists('secondary_sections', 'id'), 'required', 'numeric'],
            'type' => [Rule::in(VideoTypeEnum::toArray()), 'required'],
            'url' => [function ($attribute, $value, $fail) {

                if ($this->type === VideoTypeEnum::UploadedUrl && !\is_file($this->url)) {

                    $fail("url must be video type mp4");
                } elseif ($this->type === VideoTypeEnum::UploadedUrl && \is_file($this->url) &&
                    strtolower($this->url->getClientOriginalExtension()) != "mp4"
                ) {
                    $fail("url must be video type mp4");
                } elseif ($this->type === VideoTypeEnum::TextUrl
                    && \is_file($this->url)
                ) {
                    $fail("url must be text");
                }
            }],
        ];
    }
}
