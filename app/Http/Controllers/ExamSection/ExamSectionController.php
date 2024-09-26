<?php

namespace App\Http\Controllers\ExamSection;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\ExamSection\AddExamSectionRequest;
use App\Models\ExamSection;
use App\Models\ExamSectionMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ExamSectionController extends Controller
{
    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddExamSectionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['exam_id', 'name', 'files']);
        $examSection = $this->repositoryClass->Create(ExamSection::class, $arr);
        if(\array_key_exists('files',$arr)) {
            $this->AddFilesExamSection($examSection->id, $arr['files']);
        }
        return \Success(__('general.AddExamSection'));
    }

    private function AddFilesExamSection($id, $files)
    {
        $path = 'Exams/Files/';
        foreach ($files as $file) {
            $arr = [
                'exam_section_id' => $id,
                'url' => \UploadFile($file,$path),
            ];
       $this->repositoryClass->Create(ExamSectionMedia::class,$arr);
        }

    }
}
