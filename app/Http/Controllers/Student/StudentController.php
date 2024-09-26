<?php

namespace App\Http\Controllers\Student;

use App\Enums\ActorTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Student\AddStudentRequest;
use App\Http\Requests\Student\ChangeOrderStatusRequest;
use App\Http\Requests\Student\CreateOrdersRequest;
use App\Http\Requests\Student\OrderIdRequest;
use App\Http\Requests\Student\ShowOrdersRequest;
use App\Http\Requests\Student\StudentIdRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Student\ShowBillsResource;
use App\Http\Resources\Student\ShowStudentResource;
use App\Models\Actor;
use App\Models\SecondarySection;
use App\Models\UserSecondarySection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StudentController extends Controller
{
    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddStudentRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'email', 'password', 'phone']);
        $arr['type'] = ActorTypeEnum::Student;
        $student = $this->repositoryClass->Create(Actor::class, $arr);
        $token = $student->createToken('ActorSeeder')->plainTextToken;
        $student['token'] = $token;
        return \SuccessData(__('general.AddStudent'), new LoginResource($student));
    }


    public function ShowAll()
    {
        $perPage = \returnPerPage();
        $where = [
            'type' => ActorTypeEnum::Student,
        ];
        $students = $this->repositoryClass->ShowAll(Actor::class, $where)->paginate($perPage);
        ShowStudentResource::collection($students);
        return \Pagination($students);
    }

    public function ShowBills(StudentIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['studentId']);
        $perPage = \returnPerPage();
        $where = ['actor_id' => $arr['studentId']];
        $bills = $this->repositoryClass->ShowAll(UserSecondarySection::class, $where)->paginate($perPage);

        ShowBillsResource::collection($bills);
        return \Pagination($bills);


    }

    public function DeleteById(StudentIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['studentId']);
        $this->repositoryClass->DeleteById(Actor::class, $arr['studentId']);
        return \Success(__('general.StudentDelete'));
    }

    public function CreateOrders(CreateOrdersRequest $request)
    {
        $arr = Arr::only($request->validated(), ['course_ids']);
        $arr['actor_id'] = \auth('actor')->user()->id;
        foreach ($arr['course_ids'] as $course_id) {
            $secondarySection = $this->repositoryClass->ShowById(SecondarySection::class, $course_id);
            $array = [
                'secondary_section_id' => $course_id,
                'actor_id' => $arr['actor_id'],
                'price' => $secondarySection->price,
            ];
            $this->repositoryClass->Create(UserSecondarySection::class, $array);
        }
        return \Success(__('general.AddOrders'));
    }

    public function ChangeOrderStatus(ChangeOrderStatusRequest $request)
    {
        $arr = Arr::only($request->validated(), ['orderId', 'status']);
        $this->repositoryClass->Update(UserSecondarySection::class, $arr['orderId'], $arr);
        return \Success(__('general.OrderChangeStatus'));

    }


    public function ShowOrders(ShowOrdersRequest $request)
    {
        $arr = Arr::only($request->validated(), ['studentId', 'status']);
        $perPage = \returnPerPage();
        $where = [
            'actor_id' => $arr['studentId'],
            'status' => $arr['status'],
        ];
        $orders = $this->repositoryClass->ShowAll(UserSecondarySection::class,$where)->paginate($perPage);
        ShowBillsResource::collection($orders);
        return \Pagination($orders);
    }

}
