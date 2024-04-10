<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Repositories\Admin\BannerRepository;
use App\Services\FilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{

    public function __construct(private BannerRepository $bannerRepository, private FilesService $fileService) {
        $this->bannerRepository = $bannerRepository;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->bannerRepository->getRaw($request?->filterData);
            if (empty($request->order)) {
                $data->latest('id');
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function($row) {
                        return '<span class="badge badge-'. ($row->status == "Active" ? "success" : "danger") .'">'. $row->status .'</span>' .
                        PHP_EOL;
                    })
                    ->addColumn('action', function($row){
                            return '<div style="width: 150px">' .
                            '<a href="'. route('admin.banner.edit', $row->id) .'" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                            '<button onclick="removeData('. $row->id. ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                            '<div>' .
                            PHP_EOL;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.banner.index', [
            'upload_path' => Banner::UPLOAD_PATH
        ]);
    }

    public function create(): View
    {
        return view('admin.banner.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.banner.store'),
        ]);
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $validated['image'] = $this->fileService->generateFileName('banner', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Banner::UPLOAD_PATH,
                $validated['image']
            );
        }
        $this->bannerRepository->create($validated);

        return redirect(route('admin.banner.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.alter', [
            'banner' => $banner,
            'action' => 'Edit',
            'actionUrl' => route('admin.banner.update', $banner),
        ]);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $this->fileService->removeFile(Banner::UPLOAD_PATH, $banner->image);
            $validated['image'] = $this->fileService->generateFileName('banner', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Banner::UPLOAD_PATH,
                $validated['image']
            );
        }

        $this->bannerRepository->update($banner->id, $validated);
        return redirect(route('admin.banner.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            $this->fileService->removeFile(Banner::UPLOAD_PATH, $banner->image);
        }

        $banner->delete();
        return redirect(route('admin.banner.index'))->with('success', 'Data Deleted Successfully !');
    }
}
