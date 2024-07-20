<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Image;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class InformasiController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNumber)
    {   
        $data = Informasi::paginate(10, ['*'], 'page', $pageNumber);
        foreach ($data as $key => $value) {
            $data[$key]['url'] = asset('images/'.$value->image);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function addimage(Request $request)
    {
        $image = new Image;
        // dd($request->all());
        $image->title = $request->title;
        // dd($image->image);
            if ($request->hasFile('image')) {
                $file = $request->image;
                // dd($file);
                $destinationPath = public_path().'/images/';
                // dd($destinationPath);
                $filename= $file->getClientOriginalName();
                // dd($filename);
                $file->move($destinationPath, $filename);
           }
        $info = Informasi::create([
            'info_text' => $request->info_text,
            'image' => $filename,
        ]);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data informasi created successfully',
            'data' => $info
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function show(Informasi $informasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Informasi $informasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Informasi $informasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = Informasi::where('info_id',$request->info_id)->delete();

        if($data)
        return response()->json('Oke.', Response::HTTP_OK);
        else
        return response()->json(['error' => 'Data tidak ditemukan'], 200);
    }
}
