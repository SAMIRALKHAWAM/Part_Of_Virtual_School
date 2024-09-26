<?php

namespace App\Http\Controllers\SecondarySection;

use App\Enums\VideoTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\File\AddFileRequest;
use App\Http\Requests\File\FileIdRequest;
use App\Http\Requests\SecondarySection\AddSecondarySectionRequest;
use App\Http\Requests\SecondarySection\EditSecondarySectionRequest;
use App\Http\Requests\SecondarySection\SecondarySectionIdRequest;

use App\Http\Requests\Video\AddVideoRequest;
use App\Http\Requests\Video\VideoIdRequest;
use App\Http\Resources\SecondarySection\ShowSecondarySectionDataRequest;
use App\Models\File;
use App\Models\SecondarySection;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SecondarySectionController extends Controller
{

    public function __construct(public RepositoryClass $repositoryClass)
    {
    }


    public function ShowById(SecondarySectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['secondarySectionId']);
        $secondarySection = $this->repositoryClass->ShowById(SecondarySection::class, $arr['secondarySectionId']);
        return \SuccessData(__('general.SecondarySectionFound'), $secondarySection);
    }

    public function ShowByIdWithData(SecondarySectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['secondarySectionId']);
        $secondarySection = $this->repositoryClass->ShowById(SecondarySection::class, $arr['secondarySectionId']);
        $secondarySection = new ShowSecondarySectionDataRequest($secondarySection);
        return \SuccessData(__('general.SecondarySectionFound'), $secondarySection);

    }

    public function DeleteById(SecondarySectionIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['secondarySectionId']);
        $secondarySection = $this->repositoryClass->ShowById(SecondarySection::class, $arr['secondarySectionId']);
        $secondarySection->Videos()->delete();
        $secondarySection->Files()->delete();
        $secondarySection->delete();
        return \Success(__('general.SecondarySectionDelete'));

    }

    public function Update(EditSecondarySectionRequest $request)
    {
        $arr = Arr::only($request->validated(), ['secondarySectionId', 'name', 'price']);
        $this->repositoryClass->Update(SecondarySection::class, $arr['secondarySectionId'], $arr);
        return \Success(__('general.SecondarySectionUpdate'));

    }

    public function DeleteVideoFromCourse(VideoIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['videoId']);
        $this->repositoryClass->DeleteById(Video::class, $arr['videoId']);
        return \Success(__('general.VideoDelete'));
    }


    public function AddVideoToCourse(AddVideoRequest $request)
    {
        $arr = Arr::only($request->validated(), ['secondary_section_id', 'type', 'url']);
        if ($arr['type'] === VideoTypeEnum::TextUrl) {
            $arr = [
                'secondary_section_id' => $arr['secondary_section_id'],
                'url' => $arr['url'],
                'size_of_file' => 0,
            ];
        } else {
            $path = 'Videos/';
            $arr = [
                'secondary_section_id' => $arr['secondary_section_id'],
                'url' => \UploadFile($arr['url'], $path),
                'size_of_file' => \round(($arr['url']->getSize()) / 1024 / 1024, 2),
            ];

        }
        $this->repositoryClass->Create(Video::class, $arr);
        return \Success(__('general.AddVideo'));
    }


    public function DeleteFileFromCourse(FileIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['fileId']);
        $this->repositoryClass->DeleteById(File::class, $arr['fileId']);
        return \Success(__('general.FileDelete'));
    }

    public function AddFileToCourse(AddFileRequest $request)
    {
        $arr = Arr::only($request->validated(), ['secondary_section_id', 'url']);
        $path = 'Files/';
        $arr = [
            'secondary_section_id' => $arr['secondary_section_id'],
            'url' => \UploadFile($arr['url'], $path),
            'size_of_file' => \round(($arr['url']->getSize()) / 1024 / 1024, 2),
        ];
        $this->repositoryClass->Create(File::class, $arr);
        return \Success(__('general.AddFile'));
    }
}
