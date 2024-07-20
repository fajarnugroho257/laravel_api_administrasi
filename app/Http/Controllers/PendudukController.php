<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Profesi;
use Illuminate\Support\Facades\DB;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    public function list_dropdown()
    {
        // get all data
        return Profesi::select(DB::raw('CONCAT(profesi_id) AS profesi_id'), 'profesi_nama')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($pageNumber)
    {   
        $data = DB::table('penduduks AS a')
                ->select('*')
                ->join('kartukeluargas AS b', 'b.no_kk', '=', 'a.no_kk')
                ->paginate(10, ['*'], 'page', $pageNumber);
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
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
        $data = $request->only('nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tgl_lahir', 'agama', 'kewarganegaraan', 'status');
        $validator = Validator::make($data, [
            'nik' => 'required|unique:penduduks',
            'no_kk' => 'required',
            'nama_lengkap' => 'required',
            'kewarganegaraan' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $kk = Penduduk::create([
            'nik' => $request->nik,
            'profesi_id' => $request->profesi_id,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
            'agama' => $request->agama,
            'kewarganegaraan' => $request->kewarganegaraan,
            'status' => $request->status,
            'jk' => $request->jk,
        ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data penduduk created successfully',
            'data' => $kk
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data = Penduduk::where('nik', $id)->first();
        $data = DB::table('penduduks AS a')
                ->select('*')
                ->join('kartukeluargas AS b', 'b.no_kk', '=', 'a.no_kk')
                ->join('profesis AS c', 'a.profesi_id', '=', 'c.profesi_id')
                ->where('nik', $id)
                ->first();
        // respon
        if (empty($data)) {
            return response()->json(['error' => 'Data tidak ditemukan'], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data penduduk tersedia',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Penduduk $penduduk)
    {
        // Validate data
        $data = $request->only('nik_old', 'nik', 'no_kk', 'profesi_id', 'nama_lengkap', 'tempat_lahir', 'tgl_lahir', 'agama', 'kewarganegaraan', 'status');
        $params = [
            'nik_old' => 'required',
            'no_kk' => 'required',
            'profesi_id' => 'required',
            'status' => 'required',
        ];
        if ($request->nik !== $request->nik_old) {
            $params = ['nik' => 'required|unique:penduduks'];
        }
        $validator = Validator::make($data, $params);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        //update post
        $kartukeluarga = Penduduk::where('nik', $request->nik_old)
                    ->update([
                        'nik' => $request->nik,
                        'no_kk' => $request->no_kk,
                        'profesi_id' => $request->profesi_id,
                        'nama_lengkap' => $request->nama_lengkap,
                        'nama_lengkap' => $request->nama_lengkap,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tgl_lahir' => $request->tgl_lahir,
                        'alamat' => $request->alamat,
                        'agama' => $request->agama,
                        'kewarganegaraan' => $request->kewarganegaraan,
                        'status' => $request->status,
                        'jk' => $request->jk,
                    ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data penduduk updated successfully',
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
        $data = Penduduk::where('nik',$request->nik)->delete();

        if($data)
        return response()->json('Oke.', Response::HTTP_OK);
        else
        return response()->json(['error' => 'Data tidak ditemukan'], 200);
    }
}
