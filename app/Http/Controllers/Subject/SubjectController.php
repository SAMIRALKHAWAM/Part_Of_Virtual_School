<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Subject\AddSubjectRequest;
use App\Http\Requests\Subject\EditSubjectRequest;
use App\Http\Requests\Subject\SubjectIdRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SubjectController extends Controller
{

    public function __construct(public RepositoryClass $repositoryClass)
    {

    }

    public function Create(AddSubjectRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name']);
        $this->repositoryClass->Create(Subject::class, $arr);
        return \Success(__('general.SubjectAdd'));
    }

    public function DeleteById(SubjectIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['subjectId']);
        $this->repositoryClass->DeleteById(Subject::class, $arr['subjectId']);
        return \Success(__('general.SubjectDelete'));

    }

    public function Update(EditSubjectRequest $request){
        $arr = Arr::only($request->validated(),['subjectId','name']);
        $this->repositoryClass->Update(Subject::class,$arr['subjectId'],$arr);
        return \Success(__('general.SubjectUpdate'));
    }

    public function ShowById(SubjectIdRequest $request){
        $arr = Arr::only($request->validated(),['subjectId']);
        $subject = $this->repositoryClass->ShowById(Subject::class,$arr['subjectId']);
        return \SuccessData(__('general.SubjectFound'),$subject);

    }

    public function ShowAll(){
    $perPage = \returnPerPage();
    $subjects = Subject::paginate($perPage);
    return \Pagination($subjects);

    }

}
