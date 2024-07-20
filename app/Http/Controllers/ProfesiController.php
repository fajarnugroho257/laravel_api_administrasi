<?php

namespace App\Http\Controllers;

use App\Models\Profesi;
use Illuminate\Http\Request;
use App\PDFGenerate;
use PDF;

use Storage;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProfesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNumber)
    {
        // get all data
        $data = Profesi::paginate(5, ['*'], 'page', $pageNumber);
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
        $data = $request->only('profesi_nama');
        $validator = Validator::make($data, [
            'profesi_nama' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $profesi = Profesi::create([
            'profesi_nama' => $request->profesi_nama,
        ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data profesi created successfully',
            'data' => $profesi
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesi  $profesi
     * @return \Illuminate\Http\Response
     */
    public function show($profesi_id)
    {
        //
        $data = Profesi::where('profesi_id', $profesi_id)->first();
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
     * @param  \App\Models\Profesi  $profesi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Profesi $profesi)
    {
        //Validate data
        $data = $request->only('profesi_id', 'profesi_nama');
        $validator = Validator::make($data, [
            'profesi_id' => 'required',
            'profesi_nama' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //update post with new image
        $profesi = Profesi::where('profesi_id', $request->profesi_id)
                    ->update([
                        'profesi_nama' => $request->profesi_nama,
                    ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data profesi updated successfully',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profesi  $profesi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profesi $profesi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesi  $profesi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Profesi::where('profesi_id',$request->profesi_id)->delete();

        if($data)
        return response()->json('Oke.', Response::HTTP_OK);
        else
        return response()->json(['error' => 'Data tidak ditemukan'], 200);
    }

    public function downloadPDF() {
        $datas = Profesi::all();
        // dd($data);
        // dd(public_path());
        $pdf = PDF::loadView('pdf', compact('datas'));
        
        // return $pdf->download('disney.pdf');
        // $content = $pdf->download()->getOriginalContent();
        // dd($content);
        $content = $pdf->output();
        // dd($content);
        file_put_contents('oke.pdf', $content);
    }

    // public function downloadFile() {

    //     $show = [];
    //     // dd(public_path());
    //     $pdf = PDF::loadView('pdf', compact('show'));
        
    //     // return $pdf->download('disney.pdf');
    //     // $content = $pdf->download()->getOriginalContent();
    //     // dd($content);
    //     $content = $pdf->output();
    //     // dd($content);
    //     file_put_contents('oke.pdf', $content);
        
    //     $filename = 'oke.pdf';
    //     // Check if file exists in app/storage/file folder
    //     $file_path = public_path() . '/'. $filename;
    //     // dd($file_path);
    //     if (file_exists($file_path))
    //     {
    //         // Send Download
    //         return Response::download($file_path, $filename, [
    //             'Content-Length: '. filesize($file_path)
    //         ]);
    //     }
    //     else
    //     {
    //         // Error
    //         exit('Requested file does not exist on our server!');
    //     }
    // }
}
