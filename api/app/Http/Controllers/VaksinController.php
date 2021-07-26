<?php

namespace App\Http\Controllers;

use App\Models\Vaksin;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class VaksinController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user
            ->vaksin()
            ->get();
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

        $data = $request->only('jenis', 'dosis', 'tempat');
        $validator = Validator::make($data, [
            'jenis' => 'required|string',
            'dosis' => 'required',
            'tempat' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $vaksin = $this->user->vaksin()->create([
            'jenis' => $request->jenis,
            'dosis' => $request->dosis,
            'tempat' => $request->tempat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vaksinasi created successfully',
            'data' => $vaksin
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vaksin = $this->user->vaksin()->find($id);
    
        if (!$vaksin) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found.'
            ], 400);
        }
    
        return $vaksin;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaksin $vaksin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\  $
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vaksin $vaksin)
    {
        //Validate data
        $data = $request->only('jenis', 'dosis', 'tempat');
        $validator = Validator::make($data, [
            'jenis' => 'required|string',
            'dosis' => 'required',
            'tempat' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $vaksin = $vaksin->update([
            'jenis' => $request->jenis,
            'dosis' => $request->dosis,
            'tempat' => $request->tempat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $vaksin
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaksin $vaksin)
    {
        $vaksin->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Vaksin deleted successfully'
        ], Response::HTTP_OK);
    }
}
