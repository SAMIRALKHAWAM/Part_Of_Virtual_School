<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Question\AddQuestionTypeRequest;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuestionTypeController extends Controller
{
    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddQuestionTypeRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'type']);
        $this->repositoryClass->Create(QuestionType::class, $arr);
        return \Success(__('general.AddQuestionType'));

    }
}
