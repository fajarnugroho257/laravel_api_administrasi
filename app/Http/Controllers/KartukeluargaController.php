<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kartukeluarga;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class KartukeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNumber)
    {
        // get all data
        $data = Kartukeluarga::paginate(5, ['*'], 'page', $pageNumber);
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function list_dropdown()
    {
        // get all data
        return Kartukeluarga::select('no_kk','nama_kk')->get();
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
        //Validate data
        $data = $request->only('no_kk', 'nama_kk');
        $validator = Validator::make($data, [
            'no_kk' => 'required|unique:kartukeluargas',
            'nama_kk' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 500);
        }

        $kk = Kartukeluarga::create([
            'no_kk' => $request->no_kk,
            'nama_kk' => $request->nama_kk,
        ]);

        //Product created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Kartu keluarga created successfully',
            'data' => $kk
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($no_kk)
    {
        //
        $data = Kartukeluarga::where('no_kk', $no_kk)->first();
        // respon
        if (empty($data)) {
            return response()->json(['error' => 'Data tidak ditemukan'], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data Kk tersedia',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Kartukeluarga $kartukeluarga)
    {
        // Validate data
        $data = $request->only('no_kk_old', 'no_kk', 'nama_kk');
        $validator = Validator::make($data, [
            'no_kk_old' => 'required',
            'no_kk' => 'required',
            'nama_kk' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        //update post with new image
        $kartukeluarga = Kartukeluarga::where('no_kk', $request->no_kk_old)
                    ->update([
                        'no_kk' => $request->no_kk,
                        'nama_kk' => $request->nama_kk,
                    ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data kk updated successfully',
            'data' => $request->all()
        ], Response::HTTP_OK);
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
    public function destroy(Request $request)
    {
        //
        $data = Kartukeluarga::where('nik',$request->nik)->delete();

        if($data)
        return response()->json('Oke.', Response::HTTP_OK);
        else
        return response()->json(['error' => 'Data tidak ditemukan'], 200);
    }
}
