<?php

namespace App\Http\Requests\SubjectSection;

use App\Enums\VideoTypeEnum;
use App\Models\UserSubject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ConditionalRules;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AddSubjectSectionRequest extends FormRequest
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
     * @param $fail
     * @return array
     */
    public function rules(): array
    {
        $userSubject = UserSubject::find($this->user_subject_id);
        if (!$userSubject) {
            throw ValidationException::withMessages(['The selected user subject id is invalid.']);
        } else {
            $actorId = $userSubject->actor_id;
        }

        return [
            'user_subject_id' => [Rule::exists('user_subjects', 'id'), 'required', 'numeric'],
            'user_class_id' => [Rule::exists('user_classes', 'id')->where('actor_id', $actorId), 'required', 'numeric'],
            'primary_section_id' => [Rule::exists('primary_sections', 'id'), 'required', 'numeric'],
            'name' => 'required',
            'secondary_sections' => 'nullable',
            'secondary_sections.*.name' => 'required',
            'secondary_sections.*.price' => 'required|numeric',
            'secondary_sections.*.videos' => 'nullable',
            'secondary_sections.*.videos.*.type' => [Rule::in(VideoTypeEnum::toArray()), 'required'],
            'secondary_sections.*.videos.*.url' => [function ($attribute, $value, $fail) {
                $currentAttId = (int)explode('.', $attribute)[1];
                $currentAttVideoId = (int)\explode('.', $attribute)[3];
                if ($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['type'] === VideoTypeEnum::UploadedUrl
                    && !\is_file($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['url'])) {
                    $fail("url must be video type mp4");
                } elseif ($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['type'] === VideoTypeEnum::UploadedUrl &&
                    \is_file($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['url']) &&
                    strtolower($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['url']->getClientOriginalExtension()) != "mp4"
                ) {
                    $fail("url must be video type mp4");
                } elseif ($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['type'] === VideoTypeEnum::TextUrl
                    && \is_file($this->secondary_sections[$currentAttId]['videos'][$currentAttVideoId]['url'])
                ) {
                    $fail("url must be text");
                }
            }],
            'secondary_sections.*.files.*.url' => [function ($attribute, $value, $fail) {
                $currentAttId = (int)explode('.', $attribute)[1];
                $currentAttFileId = (int)\explode('.', $attribute)[3];
                if (!\is_file($this->secondary_sections[$currentAttId]['files'][$currentAttFileId]['url'])) {
                    $fail("url must be File type pdf");
                } elseif (\is_file($this->secondary_sections[$currentAttId]['files'][$currentAttFileId]['url']) &&
                    strtolower($this->secondary_sections[$currentAttId]['files'][$currentAttFileId]['url']->getClientOriginalExtension()) != "pdf"
                ) {
                    $fail("url must be File type pdf");
                }
            }],

        ];
    }
}
