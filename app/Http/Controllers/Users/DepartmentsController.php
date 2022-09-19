<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Departments;
use App\Models\Services;
use DataTables;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Departments::all();
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('department_picture', function ($row) {
                    return $row->department_picture ? '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="' . url('departments/logo') . '/' . $row->department_picture . '" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>' : '';
                })
                ->addColumn('checkbox', function ($row) {
                    $btn = '<input type="checkbox" name="departments_checkbox[]" 
                    class="departments_checkbox" value="' . $row->id . '" />';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item" href="' . url('admin/departments/edit') . '/' . $row->id . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="' . url('admin/departments/destroy') . '/' . $row->id . '"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('department_status', function ($row) {
                    return $row->department_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Inactive</span>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.departments.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'department_name' => 'required|string|max:50',
            'department_picture' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)
                ->withInput();
        }
        try {
            $files = $request->file('department_picture');

            $moved = uploadFile(
                $files,
                'departments/logo',
                $files->getClientOriginalName()
            );
            Departments::create([
                'department_name' => $request->department_name,
                'department_picture' => $moved ? $files->getClientOriginalName() : '',
                'department_description' => $request->department_description,
                'created_at' => date('Y-m-d h:i:s')
            ]);
            return redirect()->back()->with('success', "Added");
        } catch (\Exception $ex) {
            return redirect()->back()->with('danger', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
