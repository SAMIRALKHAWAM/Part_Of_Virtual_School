<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Question\AddQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{

    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddQuestionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['exam_section_id', 'question_type_id', 'question', 'file', 'mark']);
        if (\array_key_exists('file', $arr)) {
            $path = 'Exams/Files/';
            $arr['file'] = \UploadFile($arr['file'], $path);
        }
        $this->repositoryClass->Create(Question::class, $arr);
        return \Success(__('general.AddQuestion'));
    }



}
