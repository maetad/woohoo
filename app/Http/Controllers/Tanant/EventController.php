<?php

namespace App\Http\Controllers\Tanant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tanant\Event\CreateRequest;
use App\Http\Requests\Tanant\Event\UpdateRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $event = new Event;
        $event->name = $request->input('name');
        $event->detail = $request->input('detail');
        $event->status = $request->input('status');
        $event->dates = $request->input('dates', []);
        $event->save();

        return response()->json($event, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Event $event)
    {
        $event->name = $request->input('name');
        $event->detail = $request->input('detail');
        $event->status = $request->input('status');
        $event->dates = $request->input('dates', []);
        $event->save();

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->noContent();
    }
}
