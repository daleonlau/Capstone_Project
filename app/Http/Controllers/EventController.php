<?php

    namespace App\Http\Controllers;

    use App\Models\Event;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use SimpleSoftwareIO\QrCode\Facades\QrCode; // requires simplesoftwareio/simple-qrcode


    class EventController extends Controller
    {
        /**
         * List all events for the logged-in organization.
         */
        public function index()
        {
            $events = Event::where('user_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->get();

            return Inertia::render('Organization/Events/Events', [
                'events' => $events,
            ]);
        }

        /**
         * Show form to create a new event.
         */
        public function create()
        {
            return Inertia::render('Organization/Events/CreateEvent');
        }

        /**
         * Store a new event for the logged-in organization.
         */
        public function store(Request $request)
        {
            $validated = $request->validate([
                'event_name' => 'required|string|max:255',
                'event_date' => 'required|date',
                'event_fee'  => 'required|numeric|min:0',
                'year_level' => 'nullable|in:firstyear,secondyear,thirdyear,fourthyear',
                'course'     => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
            ]);

            Event::create(array_merge($validated, [
                'status'  => 'Pending',
                'user_id' => auth()->id(), // link event to organization
            ]));

            return redirect()->route('events.index')
                            ->with('success', 'Event created successfully.');
        }

        /**
         * Show edit form for an event.
         */
        public function edit(Event $event)
        {
            $this->authorizeAccess($event);

            return Inertia::render('Organization/Events/EditEvent', [
                'event' => $event,
            ]);
        }

        /**
         * Update an existing event.
         */
        public function update(Request $request, Event $event)
        {
            $this->authorizeAccess($event);

            $validated = $request->validate([
                'event_name' => 'required|string|max:255',
                'event_date' => 'required|date',
                'event_fee'  => 'required|numeric|min:0',
                'year_level' => 'nullable|in:firstyear,secondyear,thirdyear,fourthyear',
                'course'     => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
            ]);

            $event->update($validated);

            return redirect()->route('events.index')
                            ->with('success', 'Event updated successfully.');
        }

        /**
         * Delete an event.
         */
        public function destroy(Event $event)
        {
            $this->authorizeAccess($event);

            $event->delete();

            return redirect()->route('events.index')
                            ->with('success', 'Event deleted successfully.');
        }

        /**
         * Update event status (generic)
         */
        public function updateStatus(Request $request, Event $event)
        {
            $request->validate([
                'status' => 'required|in:Pending,Approved,Finished',
            ]);

            $this->authorizeAccess($event);

            $event->status = $request->status;
            $event->save();

            return back()->with('success', 'Event status updated successfully.');
        }

        /**
         * Approve event (quick action)
         */
        public function approve(Event $event)
        {
            $this->authorizeAccess($event);

            $event->update(['status' => 'Approved']);
            return back()->with('success', 'Event approved successfully.');
        }

        /**
         * Mark as finished so evaluation can start
         */
        public function finish(Event $event)
        {
            $this->authorizeAccess($event);

            $event->update(['status' => 'Finished']);
            return back()->with('success', 'Event marked as finished. Evaluations are now available.');
        }

        /**
         * Generate and show QR code (SVG) for the evaluation link.
         * Requires simplesoftwareio/simple-qrcode composer package.
         */
       
        /**
         * Ensure that only the organization that owns the event can access it.
         */
        protected function authorizeAccess(Event $event)
        {
            if ($event->user_id !== auth()->id()) {
                abort(403, 'Unauthorized access.');
            }
        }
    }

