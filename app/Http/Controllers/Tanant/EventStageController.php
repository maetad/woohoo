<?php

namespace App\Http\Controllers\Tanant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tanant\Stage\CreateRequest;
use App\Http\Requests\Tanant\Stage\UpdateRequest;
use App\Models\Event;
use App\Models\Stage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class EventStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        return response()->json($event->stages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, Event $event)
    {
        $stage = new Stage;
        $stage->name = $request->input('name');
        $stage->detail = $request->input('detail');
        $event->stages()->save($stage);

        return response()->json($stage, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, Stage $stage)
    {
        if ($event->id !== $stage->event_id) {
            throw new ModelNotFoundException;
        }

        return response()->json($stage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest      $request
     * @param  \App\Models\Event  $event
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Event $event, Stage $stage)
    {
        if ($event->id !== $stage->event_id) {
            throw new ModelNotFoundException;
        }

        $stage->name = $request->input('name');
        $stage->detail = $request->input('detail');
        $stage->save();

        return response()->json($stage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, Stage $stage)
    {
        if ($event->id !== $stage->event_id) {
            throw new ModelNotFoundException;
        }

        $stage->delete();
        return response()->noContent();
    }
}
