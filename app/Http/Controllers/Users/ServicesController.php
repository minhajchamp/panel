<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Services;
use DataTables;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Services::all();
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('service_picture', function ($row) {
                    return $row->service_picture ? '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="' . url('services/logo') . '/' . $row->service_picture . '" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>' : '';
                })
                ->addColumn('checkbox', function ($row) {
                    $btn = '<input type="checkbox" name="services_checkbox[]" class="services_checkbox" value="' . $row->id . '" />';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item" onclick="edit(this)" data-id='.$row->id.' ><i class="bx bx-edit-alt me-1"></i> Editss</a>
                      <a class="dropdown-item" href="' . url('admin/services/destroy') . '/' . $row->id . '"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('service_status', function ($row) {
                    return $row->service_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Inactive</span>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.services.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.add');
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
            'service_name' => 'required|string|max:50',
            'service_picture' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)
                ->withInput();
        }
        try {
            $files = $request->file('service_picture');

            $moved = uploadFile(
                $files,
                'services/logo',
                $files->getClientOriginalName()
            );
            Services::create([
                'service_name' => $request->service_name,
                'service_picture' => $moved ? $files->getClientOriginalName() : '',
                'service_description' => $request->service_description,
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
        $data = Services::find($id);
        return response()->json($data);
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
        try {
            $validate = Validator::make($request->all(), [
                'brand_name' => 'required|string|max:50',
                'brand_contact' => 'required',
                'brand_email' => 'required',
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)
                    ->withInput();
            }
            $files = $request->file('brand_picture');
            if ($files) {
                $moved = uploadFile(
                    $files,
                    'brands/logo',
                    $files->getClientOriginalName()
                );
                $savedImage = $files->getClientOriginalName();
            } else {
                $savedImage = basename($request->brand_picture_saved);
            }
            try {
                $services = $request->input('services');
                $records = Services::find($id);
                $records->brand_name = $request->brand_name;
                $records->brand_contact = $request->brand_contact;
                $records->brand_email = $request->brand_email;
                $records->brand_address = $request->brand_address;
                $records->brand_website = $request->brand_website;
                $records->brand_picture = $savedImage;
                $records->brand_description = $request->brand_description;
                $records->updated_at = date('Y-m-d h:i:s');
                
                if ($records->save()) {
                    if (!is_null($services) && !empty($services)) :
                        try {
                            $records->services()->sync($services);
                        } catch (\Exception $ex) {
                            Log::build([
                                'driver' => 'single',
                                'path' => storage_path('logs/brands.log'),
                            ])->info($ex->getMessage());
                        }
                    endif;
                }
                return redirect()->back()->with('success', "Success");
            } catch (\Exception $ex) {
                return redirect()->back()->with('danger', $ex->getMessage());
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('danger', $ex->getMessage());
        }
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
