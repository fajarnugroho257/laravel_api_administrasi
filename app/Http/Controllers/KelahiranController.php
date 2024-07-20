<?php

namespace App\Http\Controllers;

use App\Models\Kelahiran;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class KelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNumber)
    {
        // get all data
        // $data = Kelahiran::paginate(10, ['*'], 'page', $pageNumber);
        $data = DB::table('kelahirans AS a')
                ->select('a.*', 'b.alamat', 'b.nama_lengkap AS nama_anak', 'd.nama_lengkap AS nama_ayah', 'c.nama_lengkap AS nama_ibu')
                ->join('penduduks AS b', 'a.nik', '=', 'b.nik')
                ->join('penduduks AS c', 'a.nik_ibu', '=', 'c.nik')
                ->join('penduduks AS d', 'a.nik_ayah', '=', 'd.nik')
                ->paginate(10, ['*'], 'page', $pageNumber);

        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function list_dropdown()
    {
        // get all data
        return Penduduk::select('no_kk','nama_kk')->get();
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
        $data = $request->only('nik', 'nik_ibu', 'nik_ayah', 'tgl_lahir', 'alamat_kelahiran', 'anak_ke');
        $validator = Validator::make($data, [
            'nik' => 'required',
            'nik_ibu' => 'required',
            'nik_ayah' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $kelahiran = Kelahiran::create([
            'nik' => $request->nik,
            'nik_ibu' => $request->nik_ibu,
            'nik_ayah' => $request->nik_ayah,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat_kelahiran' => $request->alamat_kelahiran,
            'anak_ke' => $request->anak_ke,
        ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data kelahiran created successfully',
            'data' => $kelahiran
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelahiran  $kelahiran
     * @return \Illuminate\Http\Response
     */
    public function show($kelahiran_id)
    {
        //
        $data = DB::table('kelahirans AS a')
                ->select('a.*', 'b.alamat', 'b.nama_lengkap AS nama_anak', 'd.nama_lengkap AS nama_ayah', 'c.nama_lengkap AS nama_ibu')
                ->join('penduduks AS b', 'a.nik', '=', 'b.nik')
                ->join('penduduks AS c', 'a.nik_ibu', '=', 'c.nik')
                ->join('penduduks AS d', 'a.nik_ayah', '=', 'd.nik')
                ->where('kelahiran_id', $kelahiran_id)
                ->first();
        // respon
        if (empty($data)) {
            return response()->json(['error' => 'Data tidak ditemukan'], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data kelahiran tersedia',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelahiran  $kelahiran
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Kelahiran $kelahiran)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelahiran  $kelahiran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelahiran $kelahiran)
    {
        // Validate data
        $data = $request->only('kelahiran_id', 'nik', 'nik_ibu', 'nik_ayah', 'tgl_lahir', 'alamat_kelahiran', 'anak_ke');
        $params = [
            'kelahiran_id' => 'required',
            'nik' => 'required',
            'nik_ibu' => 'required',
            'nik_ayah' => 'required',
        ];
        $validator = Validator::make($data, $params);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        //update post
        $kartukeluarga = Kelahiran::where('kelahiran_id', $request->kelahiran_id)
                    ->update([
                        'nik' => $request->nik,
                        'nik_ibu' => $request->nik_ibu,
                        'nik_ayah' => $request->nik_ayah,
                        'tgl_lahir' => $request->tgl_lahir,
                        'alamat_kelahiran' => $request->alamat_kelahiran,
                        'anak_ke' => $request->anak_ke,
                    ]);
        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data kelahiran updated successfully',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelahiran  $kelahiran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Kelahiran $kelahiran)
    {
        //
        $data = Kelahiran::where('kelahiran_id',$request->kelahiran_id)->delete();

        if($data)
        return response()->json('Oke.', Response::HTTP_OK);
        else
        return response()->json(['error' => 'Data tidak ditemukan'], 200);
    }
}
