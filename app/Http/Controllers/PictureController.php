<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:5',
            'image' => 'required|image'

        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 401);
        }

        $fullFilename = $request->file('image')->getClientOriginalName();

        $filename = pathinfo( $fullFilename, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();

        $file = $filename . '_'. time() . '.' . $extension;

        $request->file('image')->storeAs('public/pictures', $file);

        $picture = Picture::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $file,
            'user_id' => Auth::user()->id
        ]);

        return response()->json($picture, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
