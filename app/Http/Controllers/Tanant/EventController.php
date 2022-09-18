<?php

namespace App\Http\Controllers\Tanant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tanant\Event\CreateRequest;
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
        $event->status = $request->input('status');
        $event->save();

        return response()->json($event, Response::HTTP_CREATED);
    }
}
