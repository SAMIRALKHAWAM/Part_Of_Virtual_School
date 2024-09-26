<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\ActorTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Teacher\AddTeacherRequest;
use App\Http\Requests\Teacher\EditTeacherClassesRequest;
use App\Http\Requests\Teacher\EditTeacherPasswordRequest;
use App\Http\Requests\Teacher\EditTeacherRequest;
use App\Http\Requests\Teacher\EditTeacherSubjectsRequest;
use App\Http\Requests\Teacher\TeacherIdRequest;
use App\Http\Resources\Teacher\TeacherClassessResource;
use App\Http\Resources\Teacher\TeacherSubjectsResource;
use App\Models\Actor;
use App\Models\UserClass;
use App\Models\UserSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TeacherController extends Controller
{
    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddTeacherRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'email', 'password', 'phone', 'subjects', 'classes']);
        $arr['type'] = ActorTypeEnum::Teacher;
        $actor = $this->repositoryClass->Create(Actor::class, $arr);
        $this->AddActorSubjects($actor->id, $arr['subjects']);
        $this->AddActorClasses($actor->id, $arr['classes']);
        return \Success(__('general.TeacherCreate'));
    }

    private function AddActorSubjects($id, $subjects)
    {
        foreach ($subjects as $subject) {
            $arr = [
                'actor_id' => $id,
                'subject_id' => $subject,
            ];
            $this->repositoryClass->Create(UserSubject::class, $arr);
        }

    }

    private function AddActorClasses($id, $classes)
    {
        foreach ($classes as $class) {
            $arr = [
                'actor_id' => $id,
                'class_id' => $class,
            ];
            $this->repositoryClass->Create(UserClass::class, $arr);
        }

    }

    public function DeleteById(TeacherIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['teacherId']);
        $teacher = $this->repositoryClass->ShowById(Actor::class, $arr['teacherId']);
        $this->DeleteTeacherData($teacher->id);
        $teacher->delete();
        return \Success(__('general.TeacherDelete'));
    }

    private function DeleteTeacherData($id)
    {
        $where = ['actor_id' => $id];
        $this->repositoryClass->ShowAll(UserClass::class, $where)->delete();
        $this->repositoryClass->ShowAll(UserSubject::class, $where)->delete();
    }


    public function ShowById(TeacherIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['teacherId']);
        $teacher = $this->repositoryClass->ShowById(Actor::class, $arr['teacherId']);
        return \SuccessData(__('general.TeacherFound'), $teacher);

    }

    public function ShowTeacherSubjects(TeacherIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['teacherId']);
        $teacher = $this->repositoryClass->ShowById(Actor::class, $arr['teacherId']);
        $subjects = $teacher->UserSubjects;
        $subjects = TeacherSubjectsResource::collection($subjects);
        return \SuccessData(__('general.TeacherSubjectsFound'), $subjects);

    }

    public function ShowTeacherClasses(TeacherIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['teacherId']);
        $teacher = $this->repositoryClass->ShowById(Actor::class, $arr['teacherId']);
        $classes = $teacher->UserClasses;
        $classes = TeacherClassessResource::collection($classes);
        return \SuccessData(__('general.TeacherClassesFound'), $classes);

    }

    public function ShowAll()
    {
        $where = ['type' => ActorTypeEnum::Teacher];
        $perPage = \returnPerPage();
        $teachers = $this->repositoryClass->ShowAll(Actor::class, $where)->paginate($perPage);
        return \Pagination($teachers);

    }

    public function Update(EditTeacherRequest $request)
    {
        $arr = Arr::only($request->validated(), ['teacherId', 'name', 'email', 'phone']);
        $this->repositoryClass->Update(Actor::class, $arr['teacherId'], $arr);
        return \Success(__('general.TeacherUpdateFound'));

    }

    public function UpdateTeacherSubjects(EditTeacherSubjectsRequest $request){
    $arr = Arr::only($request->validated(),['teacherId','subjects']);
    $teacher = $this->repositoryClass->ShowById(Actor::class,$arr['teacherId']);
    $old_subject_ids = $teacher->UserSubjects()->pluck('subject_id')->toArray();
    $new_subject_ids = $arr['subjects'];
    $common_ids =  array_intersect($old_subject_ids,$new_subject_ids);
    $where = ['actor_id' => $teacher->id];
    $this->repositoryClass->ShowAll(UserSubject::class,$where)->whereNotIn('subject_id',$common_ids)->delete();
    $new_subject_ids_to_add = \array_values(\array_diff($new_subject_ids,$common_ids));
    $this->AddActorSubjects($teacher->id,$new_subject_ids_to_add);
    return \Success(__('general.TeacherUpdateSubjectsFound'));
    }

    public function UpdateTeacherClasses(EditTeacherClassesRequest $request){
        $arr = Arr::only($request->validated(),['teacherId','classes']);
        $teacher = $this->repositoryClass->ShowById(Actor::class,$arr['teacherId']);
        $old_class_ids = $teacher->UserClasses()->pluck('class_id')->toArray();
        $new_class_ids = $arr['classes'];
        $common_ids =  array_intersect($old_class_ids,$new_class_ids);
        $where = ['actor_id' => $teacher->id];
        $this->repositoryClass->ShowAll(UserClass::class,$where)->whereNotIn('class_id',$common_ids)->delete();
        $new_class_ids_to_add = \array_values(\array_diff($new_class_ids,$common_ids));
        $this->AddActorClasses($teacher->id,$new_class_ids_to_add);
        return \Success(__('general.TeacherUpdateClassesFound'));
    }

    public function UpdateTeacherPassword(EditTeacherPasswordRequest $request){
        $arr = Arr::only($request->validated(),['teacherId','password']);
        $this->repositoryClass->Update(Actor::class,$arr['teacherId'],$arr);
        return \Success(__('general.TeacherUpdatePassword'));
    }


}
