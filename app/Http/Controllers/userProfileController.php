<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
// use App\Helpers\File\FileHelper;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MailController;

class userProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::find(auth()->user()->id);

        return view('user.index', [
            'title' => 'Akun saya',
            'active' => 'profile',
            'user' => $user,
        ]);
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
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $profile)
    {
        // dd($request);
        // dd($profile);
        $validatedData = $request->validate(
            [
                'firstname' => ['required', 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
                'lastname' => ['nullable', 'regex:/^(?![\s.]+$)[a-zA-Z\s.]*$/'],
                'gender' => 'required',
                'birthdate' => 'required',
            ],
            [
                'firstname.regex' => 'Nama hanya boleh menggunakan huruf',
                'firstname.required' => 'Nama depan harus diisi',
                'lastname.regex' => 'Nama hanya boleh menggunakan huruf',
                'lastname.required' => 'Nama belakang harus diisi',
                'gender.required' => 'Gender harus diisi',
                'birthdate.required' => 'Tanggal lahir harus diisi',
            ]
        );

        $profile->fill($request->all())->save();

        return back()->with('success', 'Berhasil memperbarui data diri');
        // dd($request);
        // $input = request()->collect()->filter(function($value){
        //     return null !== $value;
        // });

        // dd($input->keys());


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        //
    }
    public function uploadProfileImage(Request $request)
    {
        // dd($request);
        $user = User::find($request->user_id);

        $folderPathSave = 'user/' . $user->username . '/profile/';
        $image_parts = explode(";base64,", $request->profile_image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.jpg';

        $imageFullPathSave = $folderPathSave . $imageName;

        $previousProfileImage = $user->profile_image;
        if ($previousProfileImage) {
            Storage::delete($previousProfileImage);
        }

        $save = Storage::put($imageFullPathSave, $image_base64);
        $updateProfileImage = User::firstwhere('id', '=', auth()->user()->id)->update(['profile_image' => $imageFullPathSave]);
        if ($updateProfileImage) {
            return response()->json(['success' => 'Berhasil mengganti foto profil']);
        } else {
            return response()->json(['failed' => 'Gagal mengganti foto profil']);
        }
    }

    public function deleteProfileImage(Request $request)
    {
        $user = User::find($request->user_id);

        $previousProfileImage = $user->profile_image;
        if ($previousProfileImage) {
            Storage::delete($previousProfileImage);
        }

        $deleteProfileImage = User::firstwhere('id', '=', auth()->user()->id)->update(['profile_image' => Null]);
        if ($deleteProfileImage) {
            return redirect()->back()->with(['success' => 'Berhasil menghapus foto profil']);
        } else {
            return redirect()->back()->with(['failed' => 'Gagal menghapus foto profil']);
        }
    }

}
