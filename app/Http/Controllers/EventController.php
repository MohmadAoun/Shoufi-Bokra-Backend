<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request\EventRequest;
use App\Models\Event;
use Validator;

class EventController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $events = Event::all();
        return response()->json(["events"=>$events,"user"=>$user],200);
    }

    public function store(EventRequest $request)
    {
        $user = auth()->user();
        $input= $request->all();
        if ($validated->fails()) {
            return response()->json(["message"=>$validated->errors()]);
        }else{
            $event = Event::create($request->all());
            return response()->json(["message"=>"success","event"=>$event],200);
        }
       
    }

    public function show($id)
    {
        $event = Event::find($id);
        if (is_null($event)){
            return response()->json(["message"=>"not found"],404);
        }
        return response()->json(["message"=>"success","event"=>$event],200);
    }

    public function update(Request $request, Event $event)
    {
        $input = request()->all();
        $validated=Validator::make($input,[
            'title'=>'required',
            'description'=>'required'
        ]);
        if($validated()->fails()){
            return response()->json(["message"=>"failed",$validated->errors()]);
        }else{
            $event->update($input);
            return response()->json(["message"=>"success","event"=>$event],200);
        }
        }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(["message"=>"success"], 200);
    }
}
