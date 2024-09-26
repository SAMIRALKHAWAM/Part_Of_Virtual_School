<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Class\AddClassRequest;
use App\Http\Requests\Class\ClassIdRequest;
use App\Http\Requests\Class\EditClassRequest;
use App\Http\Requests\Class\EditClassSubjectsRequest;
use App\Http\Requests\Subject\SubjectIdRequest;
use App\Http\Resources\Class\ShowClassSubjectsResource;
use App\Models\Actor;
use App\Models\ClassSubject;
use App\Models\UClass;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ClassController extends Controller
{

    public function __construct(public RepositoryClass $repositoryClass)
    {

    }

    public function Create(AddClassRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'subjects']);
        $class = $this->repositoryClass->Create(UClass::class, $arr);
        $this->AddClassSubjects($class->id, $arr['subjects']);
        return \Success(__('general.ClassAdd'));
    }

    private function AddClassSubjects($id, $subjects)
    {
        foreach ($subjects as $subject) {
            $arr = [
                'class_id' => $id,
                'subject_id' => $subject,
            ];
            $this->repositoryClass->Create(ClassSubject::class, $arr);
        }

    }

    public function DeleteById(ClassIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['classId']);
        $this->repositoryClass->DeleteById(UClass::class, $arr['classId']);
        return \Success(__('general.ClassDelete'));

    }

    public function Update(EditClassRequest $request)
    {
        $arr = Arr::only($request->validated(), ['classId', 'name']);
        $this->repositoryClass->Update(UClass::class, $arr['classId'], $arr);
        return \Success(__('general.ClassUpdate'));
    }

    public function ShowById(ClassIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['classId']);
        $class = $this->repositoryClass->ShowById(UClass::class, $arr['classId']);
        return \SuccessData(__('general.ClassFound'), $class);

    }

    public function ShowAll()
    {
        $perPage = \returnPerPage();
        $classes = UClass::paginate($perPage);
        return \Pagination($classes);

    }


    public function ShowClassSubjects(ClassIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['classId']);
        $class = $this->repositoryClass->ShowById(UClass::class, $arr['classId']);
        $subjects = $class->ClassSubjects;
        $subjects = ShowClassSubjectsResource::collection($subjects);
        return \SuccessData(__('general.ClassSubjectsFound'), $subjects);

    }

    public function UpdateClassSubjects(EditClassSubjectsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['classId', 'subjects']);
        $class = $this->repositoryClass->ShowById(UClass::class, $arr['classId']);
        $old_subject_ids = $class->ClassSubjects()->pluck('subject_id')->toArray();
        $new_subject_ids = $arr['subjects'];
        $common_ids = array_intersect($old_subject_ids, $new_subject_ids);
        $where = ['class_id' => $class->id];
        $this->repositoryClass->ShowAll(ClassSubject::class, $where)->whereNotIn('subject_id', $common_ids)->delete();
        $new_subject_ids_to_add = \array_values(\array_diff($new_subject_ids, $common_ids));
        $this->AddClassSubjects($class->id, $new_subject_ids_to_add);
        return \Success(__('general.ClassSubjectsUpdate'));
    }


}
