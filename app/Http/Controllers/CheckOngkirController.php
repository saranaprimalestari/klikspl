<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckOngkirController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $provinces = Province::pluck('name', 'province_id');
        return view('ongkir', compact('provinces'));
        // $provinces = Province::all();
        // $daftarProvinsi = RajaOngkir::provinsi()->all();
        // $city = City::where('province_id', 13)->pluck('name', 'city_id');
        // $daftarKota = RajaOngkir::kota()->dariProvinsi('13')->get();
        // dd($daftarKota);
        // return view('ongkir', compact('provinces'),compact('daftarProvinsi'),compact('daftarKota'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities($id)
    {
        // $city = City::where('province_id', $id)->pluck('name', 'city_id');
        $city = City::where('province_id', $id)->get(['city_id', 'type', 'name', 'postal_code']);
        return response()->json($city);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_ongkir(Request $request)
    {
        if ($request->courier === 'all') {
            $courier = ['jne', 'pos', 'tiki'];
            for ($i = 0; $i < sizeof($courier); $i++) {
                $cost[$i] = RajaOngkir::ongkosKirim([
                    'origin'        => $request->city_origin, // ID kota/kabupaten asal
                    'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
                    'weight'        => $request->weight, // berat barang dalam gram
                    'courier'       => $courier[$i] // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
                ])->get();
            }
        } else {
            $cost = RajaOngkir::ongkosKirim([
                'origin'        => $request->city_origin, // ID kota/kabupaten asal
                'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
                'weight'        => $request->weight, // berat barang dalam gram
                'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
            ])->get();
        }
        return response()->json($cost);
    }

    public function check_ongkir_curl(Request $request)
    {
        if ($request->courier === 'all') {
            $courier = ['jne', 'pos', 'tiki'];

            for ($i = 0; $i < sizeof($courier); $i++) {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "origin=$request->city_origin&destination=$request->city_destination&weight=$request->weight&courier=$courier[$i]",
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded",
                        "key: 25b1c601a783026b4f3f20e2c9e2c4e9"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                $cost[$i] = $response;
            }
        } else {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=$request->city_origin&destination=$request->city_destination&weight=$request->weight&courier=$request->courier",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: 25b1c601a783026b4f3f20e2c9e2c4e9"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $cost = $response;
        }
        
        return $cost;
    }
}
