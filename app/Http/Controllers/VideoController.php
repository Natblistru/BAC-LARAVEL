<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Video;

class VideoController extends Controller
{
    public static function index() {
        $video =  Video::all();
        return response()->json([
            'status' => 200,
            'video' => $video,
        ]);
    }

    public static function show($id) {
        return Video::find($id); 
    }

    public static function allvideos() {
        $video =  Video::where('status',0)->get();
        return response()->json([
            'status' => 200,
            'video' => $video,
        ]);
    }

    public static function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:500',
            'source' => 'required|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' =>  $validator->messages()
            ]);
        }

        $data = [
            'title' => $request->input('title'),
            'source' => $request->input('source'),
            'status' => $request->input('status'),
        ];
    
        $combinatieColoane = [
            'title' => $data['title'],
            'source' => $data['source'],
        ];
    
    
        $existingRecord = Video::where($combinatieColoane)->first();

        if ($existingRecord) {
            $data['updated_at'] = now();
    
            Video::where($combinatieColoane)->update($data);
        } else {
            $data['created_at'] = now();
            $data['updated_at'] = now();
    
            Video::create($data);
        }
 
        return response()->json([
            'status'=>201,
            'message'=>'Video Added successfully',
        ]);
    }

    public static function edit($id) {
        $video =  Video::find($id);
        if($video) {
            return response()->json([
                'status' => 200,
                'video' => $video,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Video Id Found',
            ]);
        }
    }

    public static function update(Request $request,$id,) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:500',
            'source' => 'required|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' =>  $validator->messages()
            ]);
        }
        $video = Video::find($id);
        if($video) {
            $video->title = $request->input('title');
            $video->source = $request->input('source');
            $video->status = $request->input('status');  
            $video->updated_at = now();          
            $video->update();
            return response()->json([
                'status'=>200,
                'message'=>'Video Updated successfully',
            ]); 
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Video Id Found',
            ]); 
        }
    }
}
