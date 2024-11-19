<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use App\Models\UserEventGuest;
use App\Models\UserEventPurchaseTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TicketController extends BaseController
{
    //landing page
    public function landingPage()
    {

    }
    //display ticket
    public function displayTicket(Request $request, $eventRef,$ticket,$guest)
    {
        $web = GeneralSetting::first();
        $event = UserEvent::where('reference',$eventRef)->firstOrFail();
        //since event is valid, let us find where ticket corresponds with event
        $ticketPaid = UserEventPurchaseTicket::where([
            'id' => $ticket,
            'event_id' => $event->id,
        ])->with('purchase') ->firstOrFail();
        //find the guest
        $guest = UserEventGuest::where([
            'id' => $guest,
            'event' => $event->id,
            'purchase' => $ticketPaid->purchase->id
        ])->firstOrFail();

        return view('mobile.ads.events.download_ticket')->with([
            'web'           => $web,
            'siteName'      => $web->name,
            'pageName'      => 'Download Ticket',
            'ticket'        => $ticket,
            'guest'         => $guest,
            'event'         => $event,
            'purchase'      => $ticketPaid->purchase
        ]);
    }
    //display ticket generally
    public function displayTicketGeneral(Request $request, $eventRef,$ticket)
    {
        $web = GeneralSetting::first();
        $event = UserEvent::where('reference',$eventRef)->firstOrFail();
        //since event is valid, let us find where ticket corresponds with event
        $ticketPaid = UserEventPurchaseTicket::where([
            'id' => $ticket,
            'event_id' => $event->id,
            'user_id' => auth()->user()->id,
        ])->with('purchase') ->firstOrFail();
        //find the guest
        $guest = UserEventGuest::where([
            'event' => $event->id,
            'purchase' => $ticketPaid->purchase->id
        ])->first();

        if (empty($guest)) {
            return back()->with('error','You must add at least one guest to preview this ticket');
        }

        return view('mobile.ads.events.download_ticket_general')->with([
            'web'           => $web,
            'siteName'      => $web->name,
            'pageName'      => 'Download Ticket',
            'ticket'        => $ticketPaid,
            'guest'         => $guest,
            'event'         => $event,
            'purchase'      => $ticketPaid->purchase
        ]);
    }
    //generate .ics calendar
    public function generateICSFile(UserEvent $event, UserEventGuest $guest)
    {
        $startDateTime = new \DateTime("{$event->startDate} {$event->startTime}", new \DateTimeZone($event->eventTimeZone));
        $endDateTime = determineEventEndDate($event);

        $icsContent = "BEGIN:VCALENDAR\n";
        $icsContent .= "VERSION:2.0\n";
        $icsContent .= "BEGIN:VEVENT\n";
        $icsContent .= "UID:" . $guest->email . "\n"; // Unique ID for the event
        $icsContent .= "DTSTAMP:" . $startDateTime->format('Ymd\THis\Z') . "\n";
        $icsContent .= "DTSTART:" . $startDateTime->format('Ymd\THis\Z') . "\n";
        $icsContent .= "DTEND:" . $endDateTime->format('Ymd\THis\Z') . "\n";
        $icsContent .= "SUMMARY:" . addslashes($event->title) . "\n";

        // Add event description
        $description = $event->description;
        if ($event->eventType!=1) {
            $description .= "\nPlatform: " . $event->platform;
            $description .= "\nEvent Link: " . $event->link;
        }

        $icsContent .= "DESCRIPTION:" . addslashes($description) . "\n";
        // Add location or platform
        if ($event->eventType==1) {
            $icsContent .= "LOCATION:  ".$event->location.','.getStateFromIso2($event->state,$event->country)->name.' '.getCountryFromIso2($event->country)->name  ."\n";
        }
        $icsContent .= "END:VEVENT\n";
        $icsContent .= "END:VCALENDAR";

        return Response::make($icsContent, 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="' . textToSlug($event->title) . '.ics"',
        ]);
    }
}
