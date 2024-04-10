<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\UserReqeust;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->userRepository->getRaw($request?->filterData);
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
                            '<a href="'. route('admin.users.edit', $row->id) .'" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                            '<button onclick="removeData('. $row->id. ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                            '<div>' .
                            PHP_EOL;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.users.index');
    }

    public function create(): View
    {
        return view('admin.users.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.users.store'),
        ]);
    }

    public function store(UserReqeust $request): RedirectResponse
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);

        $this->userRepository->create($input);
        return redirect(route('admin.users.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(User $user): View
    {
        return view('admin.users.alter', [
            'user' => $user,
            'action' => 'Edit',
            'actionUrl' => route('admin.users.update', $user),
        ]);
    }

    public function update(UserReqeust $request, User $user): RedirectResponse
    {
        $this->userRepository->update($user->id, $request->validated());
        return redirect(route('admin.users.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect(route('admin.users.index'))->with('success', 'Data Deleted Successfully !');
    }
}
