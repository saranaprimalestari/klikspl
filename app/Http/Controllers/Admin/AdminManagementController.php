<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminSenderAddress;
use App\Models\AdminType;
use App\Models\SenderAddress;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $managements = Admin::all();
            return view('admin.management.index', [
                'title' => 'Manajemen Admin',
                'active' => 'management',
                'admins' => $managements,
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {

            $companies = Company::all();
            $managementTypes = AdminType::all();
            $senderAddresses = SenderAddress::all();
            return view('admin.management.create', [
                'title' => 'Input Admin Baru',
                'active' => 'management',
                'adminTypes' => $managementTypes,
                'companies' => $companies,
                'senderAddresses' => $senderAddresses,
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {

            if ($request->admin_type == 1 && is_null($request->company_id)) {
                echo 'masuk sini';
                $request->merge(['company_id' => 0]);
            } elseif (is_null($request->company_id)) {
                return redirect()->back()->with(['failed' => 'Perusahaan harus dipilih']);
            }

            if ($request->admin_type != 1 && is_null($request->sender_address_id)) {
                return redirect()->back()->with(['failed' => 'Pilih setidaknya satu lokasi pengirim']);
            }
            // dd($request);
            $validatedData = $request->validate(
                [
                    'username' => ['required', 'unique:users', 'alpha_dash', 'min:5', 'max:255', 'string'],
                    'firstname' => 'nullable',
                    'lastname' => 'nullable',
                    'admin_type' => 'required',
                    'company_id' => 'nullable',
                    'telp_no' => 'nullable',
                    'email' => 'required|unique:admins|email',
                    'password' => 'required|min:5|max:255',
                    // 'sender_address_id' => 'required',
                ],
                [
                    'username.required' => 'Username harus diisi!',
                    'username.unique' => 'Username harus harus unik!',
                    'username.min' => 'Username minimal terdiri dari 5 karakter!',
                    'username.max' => 'Username minimal terdiri dari 255 karakter!',
                    'admin_type.required' => 'Tipe Admin tidak boleh kosong!',
                    // 'company_id.required' => 'Perusahaan tidak boleh kosong!',
                    'email.required' => 'Email tidak boleh kosong!',
                    'password.required' => 'Password tidak boleh kosong!',
                    'password.min' => 'Password minimal terdiri dari 5 karakter!',
                    // 'sender_address_id.required' => 'Pilih setidaknya satu lokasi pengirim!',
                ]
            );
            $validatedData['password'] = Hash::make($validatedData['password']);
            // dd($request);

            $management = Admin::create($validatedData);

            foreach ($request->sender_address_id as $sender) {
                $managementSenderAddress = AdminSenderAddress::create([
                    'admin_id' => $management->id,
                    'sender_address_id' => $sender
                ]);
            }

            if ($management && $managementSenderAddress) {
                return redirect()->route('management.index')->with(['success' => 'Berhasil menambahkan admin']);
            } else {
                return redirect()->route('management.index')->with(['success' => 'Gagal menambahkan admin']);
            }
        } else {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $management
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $management)
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {
            $companies = Company::all();
            $managementTypes = AdminType::all();
            $senderAddresses = SenderAddress::all();
            return view('admin.management.show', [
                'title' => 'Input Admin Baru',
                'active' => 'management',
                'admin' => $management,
                'adminTypes' => $managementTypes,
                'companies' => $companies,
                'senderAddresses' => $senderAddresses,
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $management
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $management)
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {

            $companies = Company::all();
            $managementTypes = AdminType::all();
            $senderAddresses = SenderAddress::all();
            return view('admin.management.edit', [
                'title' => 'Input Admin Baru',
                'active' => 'management',
                'admin' => $management,
                'adminTypes' => $managementTypes,
                'companies' => $companies,
                'senderAddresses' => $senderAddresses,
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $management
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $management)
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {

            $validatedData = $request->validate(
                [
                    'firstname' => 'nullable',
                    'lastname' => 'nullable',
                    'admin_type' => 'required',
                    'company_id' => 'nullable',
                    'telp_no' => 'nullable|min:10|max:13|regex:/^[0-9]*$/',
                    // 'sender_address_id' => 'required',
                ],
                [
                    'admin_type.required' => 'Tipe Admin tidak boleh kosong!',
                    // 'company_id.required' => 'Perusahaan tidak boleh kosong!',
                    'password.min' => 'Password minimal terdiri dari 5 karakter!',
                    // 'sender_address_id.required' => 'Pilih setidaknya satu lokasi pengirim!',
                ]
            );

            if ($request->admin_type == 1 && is_null($request->company_id)) {
                echo 'masuk sini';
                $request->merge(['company_id' => 0]);
            } elseif (is_null($request->company_id)) {
                return redirect()->back()->with(['failed' => 'Perusahaan harus dipilih']);
            }

            if ($request->admin_type != 1 && $request->admin_type != 3 && (is_null($request->sender_address_id) || !isset($request->sender_address_id) || empty($request->sender_address_id))) {
                // dd($request->admin_type);
                return redirect()->back()->with(['failed' => 'Pilih setidaknya satu lokasi pengirim']);
            }

            if ($request->username != $management->username) {
                $validateUsername = $request->validate(
                    [
                        'username' => ['required', 'unique:users', 'alpha_dash', 'min:5', 'max:255', 'string'],
                    ],
                    [
                        'username.required' => 'Username harus diisi!',
                        'username.unique' => 'Username harus harus unik!',
                        'username.min' => 'Username minimal terdiri dari 5 karakter!',
                        'username.max' => 'Username minimal terdiri dari 255 karakter!',
                    ]
                );
                $validatedData['username'] = $validateUsername['username'];
            }
            if ($request->email != $management->email) {
                $validateEmail = $request->validate(
                    [
                        'email' => 'required|unique:admins|email'
                    ],
                    [
                        'email.required' => 'Email tidak boleh kosong!',
                        'email.unique' => 'Email harus unik!',
                        'email.required' => 'Format email tidak valid',
                    ]
                );
                $validatedData['email'] = $validateEmail['email'];
            }
            // dd($validatedData);

            if (!is_null($request->password) && !Hash::check($request->password, $management->password)) {
                $validatedData['password'] = $request->validate(
                    [
                        'password' => 'min:5|max:255',
                    ],
                    [
                        'password.min' => 'Password minimal terdiri dari 5 karakter!',
                    ]
                );
                $validatedData['password'] = Hash::make($request->password);
            }

            $updateAdmin = $management->fill($validatedData)->save();

            if (count($management->AdminSenderAddress) > 0) {
                if (count($request->sender_address_id) > 0) {
                    foreach ($request->sender_address_id as $key => $sender) {
                        // dd($management->AdminSenderAddress);
                        echo $sender;
                        echo "<br>";
                        // query mencari variant origin yang tidak diceklist dari DB
                        $SenderAddressDelete = AdminSenderAddress::where('admin_id', $management->id)->whereNotIn('sender_address_id', $request->sender_address_id)->get();
                        // dd($SenderAddressDelete);
                        echo "<br>";
                        // menghapus variant origin
                        foreach ($SenderAddressDelete as $deleteSender) {
                            $deleteSenders = $deleteSender->delete();
                        }

                        // query mencari variant origin yang tidak ada dari DB
                        $senderAdd = AdminSenderAddress::where('admin_id', $management->id)->whereIn('sender_address_id', $request->sender_address_id)->pluck('sender_address_id')->toArray();
                        // dd($senderAdd);
                        if (isset($request->sender_address_id[$key])) {
                            if (!in_array($request->sender_address_id[$key], $senderAdd)) {
                                $managementOrigin = AdminSenderAddress::create([
                                    'admin_id' => $management->id,
                                    'sender_address_id' => $request->sender_address_id[$key],
                                ]);
                            }
                        }
                    }
                } elseif ($request->admin_type == 1 && $request->admin_type == 3  && !isset($request->sender_address_id)) {
                    foreach ($management->AdminSenderAddress as $SenderAddressDelete) {
                        $SenderAddressDelete->delete();
                    }
                }
            } else {
                if (isset($request->sender_address_id)) {
                    foreach ($request->sender_address_id as $key => $sender) {
                        $managementOrigin = AdminSenderAddress::create([
                            'admin_id' => $management->id,
                            'sender_address_id' => $sender,
                        ]);
                    }
                }
            }

            if ($updateAdmin) {
                return redirect()->route('management.index')->with(['success' => 'Berhasil memperbarui data admin']);
            } else {
                return redirect()->route('management.index')->with(['success' => 'Gagal memperbarui data admin']);
            }
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $management
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $management)
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1) {

            // dd($management);
            if (auth()->guard('adminMiddle')->user()->id) {
                $delete = $management->delete();
                if ($delete) {
                    return redirect()->back()->with('success', 'Berhasil menghapus Admin.');
                } else {
                    return redirect()->back()->with('failed', 'Terjadi kesalahan menghapus Admin.');
                }
                // Post::destroy($post->id);
            } else {
                // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
                abort(403);
            }
        } else {
            abort(403);
        }
    }
}
