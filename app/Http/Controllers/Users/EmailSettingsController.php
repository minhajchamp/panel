<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\EmailSettings as EmailSet;
use App\Models\SMTPSettings;
use App\Models\Brands;
use DataTables;

class EmailSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = EmailSet::all();
            return Datatables::of($query)
                ->addIndexColumn()
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
                      <a class="dropdown-item" onclick="edit(this)" data-id=' . $row->id . ' ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Inactive</span>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.email_settings.list');
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

    /**
     * smtp configurations
     *
     * @return \Illuminate\Http\Response
     */
    public function smtp_config(Request $request)
    {
        $brands = Brands::where('brand_status',1)->get();
        if ($request->ajax()) {
            $query = SMTPSettings::all();
            return Datatables::of($query)
                ->addIndexColumn()
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
                      <a class="dropdown-item" onclick="edit(this)" data-id=' . $row->id . ' ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('smtp_status', function ($row) {
                    return $row->smtp_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Inactive</span>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.emails.smtp', with(compact('brands')));
    }

    /**
     * smtp configurations
     *
     * @return \Illuminate\Http\Response
     */
    public function store_smtp(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'smtp_name' => 'required|string|max:50',
            'brand_id' => 'required',
            'smtp_username' => 'required|email',
            'smtp_password' => 'required',
            'smtp_port' => 'required',
            'smtp_driver' => 'required',
            'smtp_host' => 'required',
            'smtp_encryption' => 'required',
            'smtp_from_address' => 'required|email'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)
                ->withInput();
        }
        try {
            SMTPSettings::create([
                'smtp_name' => $request->smtp_name,
                'brand_id'  => $request->brand_id,
                'smtp_username' => $request->smtp_username,
                'smtp_password' => $request->smtp_password,
                'smtp_port' => $request->smtp_port,
                'smtp_driver' => $request->smtp_driver,
                'smtp_host' => $request->smtp_host,
                'smtp_encryption' => $request->smtp_encryption,
                'smtp_from_address' => $request->smtp_from_address,
                'created_at' => date('Y-m-d h:i:s')
            ]);
            return redirect()->back()->with('success', "Added");
        } catch (\Exception $ex) {
            return redirect()->back()->with('danger', $ex->getMessage());
        }
        return view('admin.emails.smtp');
    }
}
