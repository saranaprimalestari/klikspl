<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminPaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethod = PaymentMethod::all();
        return view('admin.finance.payment-method', [
            'title' => 'Rekening Pembayaran',
            'active' => 'payment-method',
            'paymentMethod' => $paymentMethod,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('paymentmethod.index');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // dd($request);
        // $paymentMethod = PaymentMethod::find($request->payment_id);

        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'account_name' => 'required',
                'type' => 'required',
                'account_number' => 'required',
                'code' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'Nama merk harus diisi!',
                'name.regex' => 'Nama merk tidak boleh mengandung angka, simbol!, atau karakter khusus',
                'account_name.required' => 'Nama merk harus diisi!',
                'type.required' => 'Nama merk harus diisi!',
                'account_number.required' => 'Nama merk harus diisi!',
                'code.required' => 'Nama merk harus diisi!',
                'description.required' => 'Nama merk harus diisi!',
            ]
        );

        if (!is_null($request->file('logo'))) {
            // dd($request->file('logo'));
            $validateLogo = $request->validate(
                [
                    'logo' => 'image|file||mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'logo.image' => 'Logo merk harus berupa gambar',
                    'logo.file' => 'Logo merk harus berupa file',
                    'logo.mimes' => 'Logo merk harus memiliki format file .jpg, .jpeg, .png',
                    'logo.max' => 'Logo merk berukuran maximal 2MB',
                ]
            );
            $folderPathSave = 'img/payment-method/';
            $imageName = date('Ymd') . '-' . $request->name . '.' . $request->file('logo')->extension();
            $upload  = $request->file('logo')->move($folderPathSave, $imageName);

            // $paymentMethod->logo = $folderPathSave . $imageName;
        }

        $paymentMethod = PaymentMethod::create([
            'account_name' => $validatedData['account_name'],
            'name' => $validatedData['name'],
            'type' => $validatedData['type'],
            'account_number' => $validatedData['account_number'],
            'code' => $validatedData['code'],
            'description' => $validatedData['description'],
            'is_active' => 1,
        ]);
       
        if ($paymentMethod) {
            return redirect()->back()->with('addSuccess', 'Sukses memperbarui metode pembayaran');
        } else {
            return redirect()->back()->with('addFailed', 'Gagal memperbarui metode pembayaran');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        return redirect()->route('paymentmethod.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return redirect()->route('paymentmethod.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        // dd($request);

        $paymentMethod = PaymentMethod::find($request->payment_id);

        $validatedData = $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'account_name' => 'required',
                'type' => 'required',
                'account_number' => 'required',
                'code' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'Nama merk harus diisi!',
                'name.regex' => 'Nama merk tidak boleh mengandung angka, simbol!, atau karakter khusus',
                'account_name.required' => 'Nama merk harus diisi!',
                'type.required' => 'Nama merk harus diisi!',
                'account_number.required' => 'Nama merk harus diisi!',
                'code.required' => 'Nama merk harus diisi!',
                'description.required' => 'Nama merk harus diisi!',
            ]
        );

        if (!is_null($request->file('logo'))) {
            $validatedImage = $request->validate(
                [
                    'logo' => 'image|file||mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'logo.image' => 'Logo merk harus berupa gambar',
                    'logo.file' => 'Logo merk harus berupa file',
                    'logo.mimes' => 'Logo merk harus memiliki format file .jpg, .jpeg, .png',
                    'logo.max' => 'Logo merk berukuran maximal 2MB',
                ]
            );
            $folderPathSave = 'img/payment-method/';
            $imageName = date('Ymd') . '-' . $request->slug . '.' . $request->file('logo')->extension();
            $upload  = $request->file('logo')->move($folderPathSave, $imageName);

            $paymentMethod->logo = $folderPathSave . $imageName;
        }

        $paymentMethod->account_name = $validatedData['account_name'];
        $paymentMethod->name = $validatedData['name'];
        $paymentMethod->type = $validatedData['type'];
        $paymentMethod->account_number = $validatedData['account_number'];
        $paymentMethod->code = $validatedData['code'];
        $paymentMethod->description = $validatedData['description'];
        $update = $paymentMethod->save();

        if ($update) {
            return redirect()->back()->with('addSuccess', 'Sukses memperbarui metode pembayaran');
        } else {
            return redirect()->back()->with('addFailed', 'Gagal memperbarui metode pembayaran');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentmethod, Request $request)
    {
        // dd('destroy');
        // dd($paymentmethod);
        if (auth()->guard('adminMiddle')->user()->id) {
            $delete = $paymentmethod->delete();
            if ($delete) {
                return redirect()->back()->with('addSuccess', 'Berhasil menghapus metode pembayaran.');
            } else {
                return redirect()->back()->with('addFailed', 'Terjadi kesalahan menghapus metode pembayaran.');
            }
            // Post::destroy($post->id);
        } else {
            // return redirect('/dashboard/posts')->with('failed','Delete post failed!');
            abort(403);
        }
    }

    public function updateStatus(Request $request)
    {
        // dd($cart);
        // $city = CartItem::where('id', $id)->get();
        // return response()->json($city);
        // dd($request);
        // if ($request->id) {
        $status = PaymentMethod::find($request->id);
        $status->is_active = $request->status;
        $status->save();
        // }
        // session()->flash('success', 'Berhasil memperbarui jumlah item');
        $update = PaymentMethod::where('id', $request->id)->first();
        if ($update) {
            $message = 'success';
        } else {
            $message = 'failed';
        }
        return response()->json([
            'message' => $message,
            'data' => $update,
            'id' => $update->id,
            'status' => $update->is_active,
        ]);
    }
}
