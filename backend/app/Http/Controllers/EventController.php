<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAttendeeRequest;
use App\Http\Requests\StoreEventRequest;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * GET /api/events
     */
    public function index(): JsonResponse
    {
        $events = Event::withCount('attendees')
            ->orderBy('date')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $events,
        ]);
    }

    /**
     * POST /api/events
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = Event::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Az esemény sikeresen létrehozva.',
            'data'    => $event,
        ], 201);
    }

    /**
     * POST /api/events/{id}/register
     */
    public function register(RegisterAttendeeRequest $request, int $id): JsonResponse
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Az esemény nem található.',
            ], 404);
        }

        $attendee = Attendee::create([
            'event_id' => $event->id,
            'name'     => $request->validated('name'),
            'email'    => $request->validated('email'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'A regisztráció sikeres.',
            'data'    => [
                'attendee' => $attendee,
                'event'    => $event,
            ],
        ], 201);
    }

    /**
     * GET /api/events/{id}/attendees
     */
    public function attendees(int $id): JsonResponse
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Az esemény nem található.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $event->attendees()->orderBy('created_at')->get(),
        ]);
    }
}
