<?php

namespace App\Helpers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class CalendarManager
{

    private static $calendarId = "ffb2ad4ed52317cf5b80a1ea6cb3e39e3d46154b3276a60916b2fbc2034789fb@group.calendar.google.com";

    static function create_event() {
        $raw_credentials = env('GOOGLE_CALENDAR_SERVICE_ACCOUNT', null);
        $credentials = json_decode($raw_credentials, true);

        $client = new Google_Client();

        $client->setScopes(array(Google_Service_Calendar::CALENDAR));
        $client->setApplicationName("Techneek Dev Calendar");
        $client->setAuthConfig($credentials);
        $client->setAccessType('offline');
        $client->getAccessToken();
        $client->getRefreshToken();

        $service = new Google_Service_Calendar($client);

        $event   = new Google_Service_Calendar_Event(array(
            'summary' => 'techneek-dev-demo',
            'location' => '800 Howard St., San Francisco, CA 94103',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
            'dateTime' => '2024-10-04T09:00:00-06:00',
            'timeZone' => 'America/Los_Angeles',
            ),
            'end' => array(
            'dateTime' => '2024-10-04T10:00:00-06:00',
            'timeZone' => 'America/Los_Angeles',
            ),
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => 'iei-ipad-wtf', // Replace with a unique ID
                ],
            ],
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => [
                //[
                //    'email' => 'attendee@example.com', // Replace with the attendee's email address
                //],
            ],
            'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
            ),
        ));

        $event      = $service->events->insert(self::$calendarId, $event);
        return $event->htmlLink;
    }
}

