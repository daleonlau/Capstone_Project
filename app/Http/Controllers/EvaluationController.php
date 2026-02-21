<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluationController extends Controller
{
    /**
     * Show all finished events for the authenticated organization.
     */
    public function index()
    {
        $events = Event::where('user_id', auth()->id())
            ->where('status', 'Finished')
            ->get();

        return Inertia::render('Organization/Evaluation/Index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the evaluation form for a specific event.
     */
    public function form(Event $event)
    {
        // Likert-scale survey questions
        $questions = [
            "The objectives of the event were clearly defined.",
            "The event was well organized and executed.",
            "The speakers or facilitators were engaging and knowledgeable.",
            "The event activities were relevant and enjoyable.",
            "Overall, the event met my expectations.",
        ];

        $scaleLabels = [
            5 => "Excellent",
            4 => "Good",
            3 => "Fair",
            2 => "Poor",
            1 => "Very Poor",
        ];

        return Inertia::render('Organization/Evaluation/EvaluationForm', [
            'event' => $event,
            'questions' => $questions,
            'scaleLabels' => $scaleLabels,
        ]);
    }

    /**
     * Store the submitted evaluation.
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'student_id' => 'required|string',
            'answers' => 'required|array',
        ]);

        // Prevent duplicate evaluations
        $exists = Evaluation::where('event_id', $event->id)
            ->where('student_id', $validated['student_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_id' => 'You have already submitted an evaluation for this event.',
            ]);
        }

        Evaluation::create([
            'event_id' => $event->id,
            'student_id' => $validated['student_id'],
            'answers' => json_encode($validated['answers']),
        ]);

        return redirect()->route('evaluations.thankyou');
    }

    /**
     * Display the evaluation results for a specific event.
     */
    public function results(Event $event)
    {
        $evaluations = $event->evaluations()->get();

        if ($evaluations->isEmpty()) {
            return Inertia::render('Organization/Evaluation/EvaluationResult', [
                'event' => $event,
                'evaluationData' => [],
                'rawData' => [],
            ]);
        }

        // Decode all answers
        $responses = $evaluations->pluck('answers')->map(fn($a) => json_decode($a, true));

        // Maximum number of questions
        $maxQuestions = max(array_map('count', $responses->toArray()));

        $averages = [];
        $rawData = [];

        for ($i = 0; $i < $maxQuestions; $i++) {
            $values = [];

            foreach ($responses as $answers) {
                if (isset($answers[$i]) && is_numeric($answers[$i])) {
                    $values[] = $answers[$i];
                }
            }

            if (count($values) > 0) {
                $averages[] = [
                    'question' => "Question " . ($i + 1),
                    'average' => round(array_sum($values) / count($values), 2),
                    'responses' => count($values),
                ];

                $rawData[] = [
                    'question' => "Question " . ($i + 1),
                    'answers' => $values,
                ];
            }
        }

        return Inertia::render('Organization/Evaluation/EvaluationResult', [
            'event' => $event,
            'evaluationData' => $averages,
            'rawData' => $rawData,
        ]);
    }

    /**
     * Show the thank you page after submission.
     */
    public function thankyou()
    {
        return Inertia::render('Organization/Evaluation/ThankYou');
    }

    /**
     * Generate and display the QR code for a specific event.
     */
    public function qr(Event $event)
    {
        $lanIp = getHostByName(getHostName());
        $evaluationUrl = "http://{$lanIp}:8000/evaluations/{$event->id}/form";

        return Inertia::render('Organization/Evaluation/EvaluationQr', [
            'event' => $event,
            'evaluationUrl' => $evaluationUrl,
        ]);
    }
}
