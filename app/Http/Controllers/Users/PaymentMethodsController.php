<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentMethods;
use DataTables;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = PaymentMethods::all();
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('method_picture', function ($row) {
                    return $row->method_picture ? '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="' . url('payment/logo') . '/' . $row->method_picture . '" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>' : '';
                })
                ->addColumn('checkbox', function ($row) {
                    $btn = '<input type="checkbox" name="method_checkbox[]" class="method_checkbox" value="' . $row->id . '" />';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item" onclick="edit(this)" data-id='.$row->id.' ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('method_status', function ($row) {
                    return $row->method_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Inactive</span>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.payment_methods.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment_methods.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = PaymentMethods::find($id);
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
                'method_name' => 'required|string|max:50',
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)
                    ->withInput();
            }
            $files = $request->file('method_picture');
            if ($files) {
                $moved = uploadFile(
                    $files,
                    'payment/logo',
                    $files->getClientOriginalName()
                );
                $savedImage = $files->getClientOriginalName();
            } else {
                $savedImage = basename($request->brand_picture_saved);
            }
            try {
                $details = array(
                    'p_secret_key' => $request->p_secret_key,
                    'p_publish_key' => $request->p_publish_key,
                    's_secret_key' => $request->s_secret_key,
                    's_publish_key' => $request->s_publish_key,
                );
                $records = PaymentMethods::find($id);
                $records->method_name = $request->method_name;
                $records->method_details = json_encode($details);
                $records->updated_at = date('Y-m-d h:i:s');
                $records->save();
                
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
