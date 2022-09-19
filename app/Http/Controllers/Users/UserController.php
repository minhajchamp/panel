<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Brands;
use App\Models\Role;
use App\Models\Services;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::whereNotIn('role_id', [2])->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('user_picture', function ($row) {
                    return $row->user_picture ? '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="' . url('users/emp') . '/' . $row->user_picture . '" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>' : '';
                })
                ->addColumn('checkbox', function ($row) {
                    $btn = '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="' . $row->id . '" />';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item" href="' . url('admin/users/'.$row->id.'/edit') . '"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="' . url('admin/users/destroy') . '/' . $row->id . '"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('user_verified', function ($row) use ($request) {
                    return $row->user_verified == 1 ? '<a href="' . url('admin/users/change_status/ver/0/' . $row->id) . '"><span class="text-center badge bg-label-success me-1">Verified</span></a>' : '<a href="' . url('admin/users/change_status/ver/1/' . $row->id) . '"><span class="badge bg-label-danger me-1">Not Verified</span></a>';
                })
                ->editColumn('user_status', function ($row) {
                    return $row->user_status == 1 ? '<a href="' . url('admin/users/change_status/usr_status/0/' . $row->id) . '"><span class="text-center badge bg-label-success me-1">Active</span></a>' : '<a href="' . url('admin/users/change_status/usr_status/1/' . $row->id) . '"><span class="badge bg-label-danger me-1">Not Active</span></a>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.users.list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2(Request $request)
    {
        if ($request->ajax()) {
            $query = User::whereNotIn('role_id', [1, 3])->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('user_picture', function ($row) {
                    return $row->user_picture ? '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-md pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="' . url('users/emp') . '/' . $row->user_picture . '" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>' : '';
                })
                ->addColumn('checkbox', function ($row) {
                    $btn = '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="' . $row->id . '" />';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <a class="dropdown-item" href="' . url('admin/users/'.$row->id.'/edit') .'"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="' . url('admin/users/destroy') . '/' . $row->id . '"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                  </div>';
                    return $btn;
                })
                ->editColumn('user_verified', function ($row) use ($request) {
                    return $row->user_verified == 1 ? '<a href="' . url('admin/users/change_status/ver/0/' . $row->id) . '"><span class="text-center badge bg-label-success me-1">Verified</span></a>' : '<a href="' . url('admin/users/change_status/ver/1/' . $row->id) . '"><span class="badge bg-label-danger me-1">Not Verified</span></a>';
                })
                ->editColumn('user_status', function ($row) {
                    return $row->user_status == 1 ? '<a href="' . url('admin/users/change_status/usr_status/0/' . $row->id) . '"><span class="text-center badge bg-label-success me-1">Active</span></a>' : '<a href="' . url('admin/users/change_status/usr_status/1/' . $row->id) . '"><span class="badge bg-label-danger me-1">Not Active</span></a>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.users.list2');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        if (empty(Cache::has('countries'))):
            $url = 'https://restcountries.com/v2/all';
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                $data = curl_exec($curl);
                Cache::put('countries', $data);
                curl_close($curl);
            } catch (\Exception $ex) {
            }
        endif;
        $roles = Role::all();
        $brands = Brands::all();
        $countries = !empty(Cache::has('countries')) ? json_decode(Cache::get('countries')) : json_decode($data);
        return view('admin.users.add')->with(compact('roles', 'brands', 'countries'));
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'brand_id'     => 'required',
            'role_id'     => 'required',
            'user_password' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)
                ->withInput();
        }
        try {
            $files = $request->file('user_picture');
            if (!empty($files)) :
                $moved = uploadFile(
                    $files,
                    $request->role_id == 1 || $request->role_id == 3 ? 'users/emp' : 'users/client',
                    $files->getClientOriginalName()
                );
            endif;
            $user = new User;
            $user->name = $request->first_name . " " . $request->last_name;
            $user->role_id = $request->role_id;
            $user->brand_id = $request->brand_id;
            $user->user_contact = $request->user_contact;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_country = $request->user_country;
            $user->user_city = $request->user_city;
            $user->user_state = $request->user_state;
            $user->user_address = $request->user_address;
            $user->user_currency = $request->user_currency;
            $user->user_timezone = $request->user_timezone;
            $user->user_gender = $request->user_gender;
            $user->user_dob = $request->user_dob;
            $user->user_organization = $request->user_organization;
            $user->user_language = $request->user_language;
            $user->salt_password = "helloworld";
            $user->user_picture = isset($moved) && !empty($moved) ? $files->getClientOriginalName() : '';
            // $user->user_description = $request->user_description ?? "";
            $user->created_at = date('Y-m-d h:i:s');

            if ($user->save()) {
                return redirect()->back()->with('success', "Added");
                // if (!is_null($services) && !empty($services)) :
                //     foreach ($services as $ser) :
                //         try {
                //             $services = Services::find($ser);
                //             $brand->services()->attach($ser);
                //         } catch (\Exception $ex) {
                //             Log::build([
                //                 'driver' => 'single',
                //                 'path' => storage_path('logs/brands.log'),
                //             ])->info($ex->getMessage());
                //         }
                //     endforeach;
                // endif;
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect()->back()->with('danger', $ex->getMessage());
        }
    }

    /**
     * Change status.
     * @param  int  Type of status either verify or user status
     * @param  int  $status_id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function change_status($type, $status_id, $user_id)
    {
        try {
            if ($type == "ver") :
                $user = User::find($user_id);
                $user->user_verified = $status_id;
                $user->save();
            elseif ($type == "usr_status") :
                $user = User::find($user_id);
                $user->user_status = $status_id;
                $user->save();
            else :
                $user = User::find($user_id);
                $user->user_status = $status_id;
                $user->save();
            endif;
            return redirect()->back()->with('success', "Success");
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        if (empty(Cache::has('countries'))):
            $url = 'https://restcountries.com/v2/all';
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                $data = curl_exec($curl);
                Cache::put('countries', $data);
                curl_close($curl);
            } catch (\Exception $ex) {
            }
        endif;
        $users = User::find($id);
        $roles = Role::all();
        $brands = Brands::all();
        $countries = !empty(Cache::has('countries')) ? json_decode(Cache::get('countries')) : json_decode($data);
        return view('admin.users.edit')->with(compact('users','countries','roles', 'brands'));
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
