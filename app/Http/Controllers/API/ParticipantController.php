<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Mail\ParticipantRegistered;
use App\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends BaseController
{
    /**
     * Show all Participants.
     * or filtered thru Event
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        //if there is a request with event id, return event participants

        $eventId = $request->input('event');
        if (isset($eventId)) {
            $participants = Participant::whereHas('events', function ($q) use ($eventId) {
                $q->where('id', $eventId);
            })->with('events')->get();
        } else {

            //else return all participants

            $participants = Participant::all();
        }

        if (is_null($participants)) {
            return $this->sendError('Participants not found.');
        }
        return $this->sendResponse($participants->toArray(), 'Participants retrieved successfully.');
    }

    /**
     * Store a new participant, that belongs to event.
     * @param Request $request
     * @return JsonResponse
     */
    public function store($id)
    {
        $input = \request()->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|unique:participants',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Create a participant
        $participant = Participant::create($input);
        //attach to event
        $participant->events()->attach($id);

        //if success send mail
        if ($participant->id) {
            $this->ship($participant->id);
        }

        return $this->sendResponse($participant->toArray(), 'Participant created successfully.');
    }

    /** Show participant with given id.
      * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //get participant with events
        $participant = Participant::with('events')->where('id', $id)->get();
        if (is_null($participant)) {
            return $this->sendError('Participant not found.');
        }
        return $this->sendResponse($participant->toArray(), 'Participant retrieved successfully.');
    }

    /**
     * Updates participant's data.
     * @param Request $request
     * @param Participant $participant
     * @return JsonResponse
     */
    public function update(Request $request, Participant $participant)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'surname' => 'required',
             'email' => 'required | unique:participants'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $participant->name = $input['name'];
        $participant->surname = $input['surname'];
        $participant->email = $input['email'];
        $participant->save();
        return $this->sendResponse($participant->toArray(), 'Participant updated successfully.');
    }

    /**
     * Delete given participant.
     * @param Participant $participant
     * @return JsonResponse
     */
    public function destroy(Participant $participant)
    {
        $participant->delete();
        return $this->sendResponse($participant->toArray(), 'Participant deleted successfully.');
    }

    /**
     * Emulate email to log  /storage/logs/mailer.log
     * @param int $participantId
     */
    public function ship(int $participantId)
    {
        $participant = Participant::findOrFail($participantId);
        $participant->sender ='sender';
        $participant->receiver ='receiver';

        // Ship mail...

        Mail::to("receiver@example.com")->send(new ParticipantRegistered($participant));
    }
}
