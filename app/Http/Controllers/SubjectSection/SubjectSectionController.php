<?php

namespace App\Http\Controllers\SubjectSection;

use App\Enums\VideoTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\SecondarySection\AddSecondarySectionRequest;
use App\Http\Requests\SecondarySection\SecondarySectionIdRequest;
use App\Http\Requests\SubjectSection\AddSubjectSectionRequest;
use App\Http\Requests\SubjectSection\EditSubjectSectionRequest;
use App\Http\Requests\SubjectSection\SubjectSectionIdRequest;
use App\Http\Resources\SubjectSection\ShowSubjectSectionsResource;
use App\Models\File;
use App\Models\SecondarySection;
use App\Models\SubjectSection;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SubjectSectionController extends Controller
{
    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddSubjectSectionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['user_subject_id', 'user_class_id', 'primary_section_id', 'name', 'secondary_sections']);
        $subjectSection = $this->repositoryClass->Create(SubjectSection::class, $arr);
        $this->AddCourses($subjectSection->id, $arr['secondary_sections']);
        return \Success(__('general.AddSubjectSection'));
    }


    public function CreateSecondarySection(AddSecondarySectionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['subject_section_id', 'name', 'price', 'videos', 'filesData']);
        $secondarySection = $this->repositoryClass->Create(SecondarySection::class, $arr);
        if (\array_key_exists('videos', $arr)) {
            foreach ($arr['videos'] as $video) {
                $this->AddCourseVideos($secondarySection->id, $video);
            }
        }
        if (\array_key_exists('filesData', $arr)) {
            foreach ($arr['filesData'] as $file) {
                $this->AddCourseFiles($secondarySection->id, $file);
            }
        }

        return \Success(__('general.AddSecondarySection'));
    }

    private function AddCourses($id, $secondary_sections)
    {
        foreach ($secondary_sections as $secondary_section) {
            $arr = [
                'subject_section_id' => $id,
                'name' => $secondary_section['name'],
                'price' => $secondary_section['price'],
            ];
            $new_secondary_section = $this->repositoryClass->Create(SecondarySection::class, $arr);
            if (\array_key_exists('videos', $secondary_section)) {
                $videos = $secondary_section['videos'];

                foreach ($videos as $video) {
                    $this->AddCourseVideos($new_secondary_section->id, $video);
                }
            }
            if (\array_key_exists('files', $secondary_section)) {
                $files = $secondary_section['files'];
                foreach ($files as $file) {
                    $this->AddCourseFiles($new_secondary_section->id, $file);
                }
            }
        }

    }

    private function AddCourseVideos($id, $video)
    {
        $type = $video['type'];
        if ($type === VideoTypeEnum::TextUrl) {
            $arr = [
                'secondary_section_id' => $id,
                'url' => $video['url'],
                'size_of_file' => 0,
            ];
        } else {
            $path = 'Videos/';
            $arr = [
                'secondary_section_id' => $id,
                'url' => \UploadFile($video['url'], $path),
                'size_of_file' => \round(($video['url']->getSize()) / 1024 / 1024, 2),
            ];

        }
        $this->repositoryClass->Create(Video::class, $arr);
    }

    private function AddCourseFiles($id, $file)
    {
        $path = 'Files/';
        $arr = [
            'secondary_section_id' => $id,
            'url' => \UploadFile($file['url'], $path),
            'size_of_file' => \round(($file['url']->getSize()) / 1024 / 1024, 2),
        ];
        $this->repositoryClass->Create(File::class, $arr);
    }

    public function deleteById(SubjectSectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['subjectSectionId']);
        $subjectSection = $this->repositoryClass->ShowById(SubjectSection::class, $arr['subjectSectionId']);
        foreach ($subjectSection->secondarySections()->get() as $item) {
            $item->Videos()->delete();
            $item->Files()->delete();
            $item->delete();
        }
        $subjectSection->delete();
        return \Success(__('general.DeleteSubjectSection'));
    }

    public function ShowAll()
    {
        $perPage = \returnPerPage();
        $subjectSections = $this->repositoryClass->ShowAll(SubjectSection::class, [])->Order()->paginate($perPage);
        ShowSubjectSectionsResource::collection($subjectSections);
        return \Pagination($subjectSections);
    }

    public function ShowSecondarySections(SubjectSectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['subjectSectionId']);
        $subjectSection = $this->repositoryClass->ShowById(SubjectSection::class, $arr['subjectSectionId']);
        $secondarySections = $subjectSection->SecondarySections;
        return \SuccessData(__('general.SecondarySectionFound'), $secondarySections);
    }

    public function ShowById(SubjectSectionIdRequest $request){
        $arr = Arr::only($request->validated(), ['subjectSectionId']);
        $subjectSection = $this->repositoryClass->ShowById(SubjectSection::class, $arr['subjectSectionId']);
        return \SuccessData(__('general.SubjectSectionFound'),$subjectSection);
    }

    public function Update(EditSubjectSectionRequest $request){
    $arr = Arr::only($request->validated(),['subjectSectionId','name']);
    $this->repositoryClass->Update(SubjectSection::class,$arr['subjectSectionId'],$arr);
    return \Success(__('general.SubjectSectionUpdate'));
    }

}
