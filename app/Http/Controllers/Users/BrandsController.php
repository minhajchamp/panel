<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Brands;
use App\Models\User;
use App\Models\Services;
use DataTables;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Brands::with('users')->get();
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('brand_picture', function ($row) {
                    return $row->brand_picture ? '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="' . url('brands/logo') . '/' . $row->brand_picture . '" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>' : '';
                })
                ->addColumn('checkbox', function ($row) {
                    $btn = '<input type="checkbox" name="brands_checkbox[]" class="brands_checkbox" value="' . $row->id . '" />';
                    return $btn;
                })
                ->addColumn('brand_users', function ($row) {
                    $btn = '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">';
                    foreach ($row->users as $key => $Pic) {
                        if ($key < 5) :
                            $img = $Pic->user_picture ? url('users/emp') . '/' . $Pic->user_picture : url('assets/img/avatars/5.png');
                            $btn  .= '<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                              <img src="' . $img . '" alt="Avatar" class="rounded-circle">
                            </li>';
                        endif;
                    }
                    $btn .= '</ul>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item" href="' . url('admin/brands/edit') . '/' . $row->id . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="' . url('admin/brands/destroy') . '/' . $row->id . '"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('brand_status', function ($row) {
                    return $row->brand_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Inactive</span>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.brands.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Services::where('service_status', 1)->get();
        return view('admin.brands.add')->with(compact('services'));
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
            'brand_name' => 'required|string|max:50',
            'brand_contact' => 'required',
            'brand_email' => 'required',
            'brand_picture' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)
                ->withInput();
        }
        try {
            $services = $request->input('services');
            $files = $request->file('brand_picture');

            $moved = uploadFile(
                $files,
                'brands/logo',
                $files->getClientOriginalName()
            );

            $brand = new Brands;
            $brand->brand_name = $request->brand_name;
            $brand->brand_contact = $request->brand_contact;
            $brand->brand_email = $request->brand_email;
            $brand->brand_address = $request->brand_address;
            $brand->brand_picture = $moved ? $files->getClientOriginalName() : '';
            $brand->brand_description = $request->brand_description;
            $brand->created_at = date('Y-m-d h:i:s');

            if ($brand->save()) {
                if (!is_null($services) && !empty($services)) :
                    foreach ($services as $ser):
                        try {
                            $services = Services::find($ser);
                            $brand->services()->attach($ser);
                        } catch (\Exception $ex) {
                            Log::build([
                                'driver' => 'single',
                                'path' => storage_path('logs/brands.log'),
                            ])->info($ex->getMessage());
                        }
                    endforeach;
                endif;
            }

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
        $services = Services::where('service_status', 1)->get();
        $records = Brands::with('services')->where('id', $id)->first();
        $ser_arr = [];
        if (!empty($records->services)) :
            foreach ($records->services as $ser) {
                $ser_arr[] = $ser->id;
            }
        endif;
        $selected_ser = $records->services ? $ser_arr : [];
        return view('admin.brands.edit')->with(compact('records', 'services', 'selected_ser'));
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
                $records = Brands::find($id);
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
        try {

            DB::beginTransaction();
            Brands::where('id', $id)->delete();
            DB::commit();

            return redirect()->back()->with('success', "Success");
        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->back()->with('danger', $ex->getMessage());
        }
    }

    /**
     * Remove the mass resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function mass_destroy(Request $request)
    {
        try {

            $id = $request->input('id');

            DB::beginTransaction();
            Brands::whereIn('id', $id)->delete();
            DB::commit();

            return response()->json(['success' => "Deleted"]);
        } catch (\Exception $ex) {

            DB::rollback();
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
