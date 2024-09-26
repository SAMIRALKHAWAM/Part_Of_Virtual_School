<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Exam\AddExamRequest;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ExamController extends Controller
{
  public function __construct(public RepositoryClass $repositoryClass)
  {
  }


  public function Create(AddExamRequest $request){
$arr = Arr::only($request->validated(),['class_subject_id','name']);
$this->repositoryClass->Create(Exam::class,$arr);
return \Success(__('general.AddExam'));

  }
}
