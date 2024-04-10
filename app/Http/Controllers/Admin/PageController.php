<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Repositories\Admin\PageRepository;
use App\Services\FilesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\PageRequest;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct(private PageRepository $pageRepository, private FilesService $fileService)
    {
        $this->pageRepository = $pageRepository;
        $this->fileService = $fileService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->getListingData($request);
        }

        return view('admin.pages.index');
    }

    public function getListingData(Request $request)
    {
        $data = $this->pageRepository->getRaw($request?->filterData);
        if (empty($request->order)) {
            $data->latest('id');
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                return '<span class="badge badge-' . ($row->status == "Active" ? "success" : "danger") . '">' . $row->status . '</span>' .
                    PHP_EOL;
            })
            ->addColumn('action', function ($row) {
                return '<div style="width: 250px">' .
                    '<a href="' . route('admin.pages.edit', $row->id) . '" class="edit btn btn-default btn-sm mr-2"><i class="fa fa-edit"></i> Edit</a>' .
                    PHP_EOL;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create(): View
    {
        return view('admin.pages.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.pages.store'),
        ]);
    }

    public function store(PageRequest $request): RedirectResponse
    {
        $input = $request->validated();
        $input['page_slug'] = Str::slug($input['page_name']);
        $this->pageRepository->create($input);
        return redirect(route('admin.pages.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.alter', [
            'page' => $page,
            'action' => 'Edit',
            'actionUrl' => route('admin.pages.update', $page),
        ]);
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();
        $validated['page_slug'] = Str::slug($validated['page_name']);
        $this->pageRepository->update($page->id, $validated);

        return redirect(route('admin.pages.index'))->with('success', 'Data Updated Successfully !');
    }
}
