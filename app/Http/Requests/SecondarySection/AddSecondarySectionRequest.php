<?php

namespace App\Http\Requests\SecondarySection;

use App\Enums\VideoTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSecondarySectionRequest extends FormRequest
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
            'subject_section_id' => [Rule::exists('subject_sections', 'id'), 'required', 'numeric'],
            'name' => 'required',
            'price' => 'required|numeric',
            'videos' => 'nullable',
            'videos.*.type' => [Rule::in(VideoTypeEnum::toArray()), 'required'],
            'videos.*.url' => [function ($attribute, $value, $fail) {
                $currentAttId = (int)explode('.', $attribute)[1];
                if ($this->videos[$currentAttId]['type'] === VideoTypeEnum::UploadedUrl
                    && !\is_file($this->videos[$currentAttId]['url'])) {
                    $fail("url must be video type mp4");
                } elseif ($this->videos[$currentAttId]['type'] === VideoTypeEnum::UploadedUrl &&
                    \is_file($this->videos[$currentAttId]['url']) &&
                    strtolower($this->videos[$currentAttId]['url']->getClientOriginalExtension()) != "mp4"
                ) {
                    $fail("url must be video type mp4");
                } elseif ($this->videos[$currentAttId]['type'] === VideoTypeEnum::TextUrl
                    && \is_file($this->videos[$currentAttId]['url'])
                ) {
                    $fail("url must be text");
                }
            }],

            'filesData.*.url' => [function ($attribute, $value, $fail) {
                $currentAttId = (int)explode('.', $attribute)[1];
                if (!\is_file($this->filesData[$currentAttId]['url'])) {
                    $fail("url must be File type pdf");
                } elseif (\is_file($this->filesData[$currentAttId]['url']) &&
                    strtolower($this->filesData[$currentAttId]['url']->getClientOriginalExtension()) != "pdf"
                ) {
                    $fail("url must be File type pdf");
                }
            }],
        ];
    }
}
