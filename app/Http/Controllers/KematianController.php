<?php

namespace App\Http\Controllers;

use App\Models\Kematian;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class KematianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNumber)
    {
        // get all data
        $data = DB::table('kematians AS a')
                ->select('*')
                ->join('penduduks AS b', 'b.nik', '=', 'a.nik')
                ->paginate(10, ['*'], 'page', $pageNumber);
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function list_dropdown()
    {
        // get all data
        return Penduduk::select('nik','nama_lengkap')->get();
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
        $data = $request->only('nik', 'tgl_kematian');
        $validator = Validator::make($data, [
            'nik' => 'required',
            'tgl_kematian' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $kematian = Kematian::create([
            'nik' => $request->nik,
            'tgl_kematian' => $request->tgl_kematian,
        ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data kematian created successfully',
            'data' => $kematian
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kematian  $kematian
     * @return \Illuminate\Http\Response
     */
    public function show($kematian_id)
    {
        //
        $data = DB::table('kematians AS a')
                ->select('*')
                ->join('penduduks AS b', 'a.nik', '=', 'b.nik')
                ->join('profesis AS c', 'b.profesi_id', '=', 'c.profesi_id')
                ->where('kematian_id', $kematian_id)
                ->first();
        // respon
        if (empty($data)) {
            return response()->json(['error' => 'Data tidak ditemukan'], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data kematian tersedia',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kematian  $kematian
     * @return \Illuminate\Http\Response
     */
    public function edit(Kematian $kematian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kematian  $kematian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kematian $kematian)
    {
        // Validate data
        $data = $request->only('kematian_id', 'nik', 'tgl_kematian');
        $params = [
            'kematian_id' => 'required',
            'nik' => 'required',
            'tgl_kematian' => 'required',
        ];
        $validator = Validator::make($data, $params);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        //update post
        $kartukeluarga = Kematian::where('kematian_id', $request->kematian_id)
                    ->update([
                        'nik' => $request->nik,
                        'tgl_kematian' => $request->tgl_kematian,
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
     * @param  \App\Models\Kematian  $kematian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = Kematian::where('kematian_id',$request->kematian_id)->delete();

        if($data)
        return response()->json('Oke.', Response::HTTP_OK);
        else
        return response()->json(['error' => 'Data tidak ditemukan'], 200);
    }
}
