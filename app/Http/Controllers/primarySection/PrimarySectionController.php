<?php

namespace App\Http\Controllers\primarySection;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\PrimarySection\AddPrimarySectionRequest;
use App\Http\Requests\PrimarySection\EditPrimarySectionRequest;
use App\Http\Requests\PrimarySection\PrimarySectionIdRequest;
use App\Models\PrimarySection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PrimarySectionController extends Controller
{


    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Create(AddPrimarySectionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name']);
        $this->repositoryClass->Create(PrimarySection::class, $arr);
        return \Success(__('general.AddPrimarySection'));

    }


    public function DeleteById(PrimarySectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['primarySectionId']);
        $primarySection = $this->repositoryClass->DeleteById(PrimarySection::class, $arr['primarySectionId']);
        return \Success(__('general.PrimarySectionDelete'));


    }

    public function Update(EditPrimarySectionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['primarySectionId', 'name']);
        $this->repositoryClass->Update(PrimarySection::class, $arr['primarySectionId'], $arr);
        return \Success(__('general.PrimarySectionUpdate'));
    }

    public function ShowById(PrimarySectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['primarySectionId']);
        $primarySection = $this->repositoryClass->ShowById(PrimarySection::class, $arr['primarySectionId']);
        return \SuccessData(__('general.PrimarySectionFound'), $primarySection);


    }

    public function ShowAll()
    {
        $perPage = \returnPerPage();
        $primarySections = $this->repositoryClass->ShowAll(PrimarySection::class, [])->paginate($perPage);
        return \Pagination($primarySections);


    }
}
