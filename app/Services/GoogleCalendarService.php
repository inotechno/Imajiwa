<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use App\Models\SocialAccount;
use Exception;

class GoogleCalendarService
{
    protected function getClient($user)
    {
        $social = SocialAccount::where('user_id', $user->id)
            ->where('provider_name', 'google')
            ->first();

        if (!$social || !$social->access_token) {
            throw new Exception("Google Calendar belum terhubung untuk user ini.");
        }

        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(Calendar::CALENDAR_EVENTS);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $client->setAccessToken([
            'access_token'  => $social->access_token,
            'refresh_token' => $social->refresh_token,
        ]);

        if ($client->isAccessTokenExpired()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $social->update([
                'access_token'      => $newToken['access_token'] ?? $social->access_token,
                'token_expires_at'  => now()->addSeconds($newToken['expires_in'] ?? 3600),
            ]);
        }

        return new Calendar($client);
    }

    public function createEvent($user, $task)
    {
        $service = $this->getClient($user);

        $event = new Event([
            'summary'     => $task->title,
            'description' => $task->description ?? '',
            'start'       => [
                'dateTime' => date('c', strtotime($task->start_date)),
                'timeZone' => 'Asia/Jakarta',
            ],
            'end'         => [
                'dateTime' => date('c', strtotime($task->end_date)),
                'timeZone' => 'Asia/Jakarta',
            ],
        ]);

        return $service->events->insert('primary', $event);
    }

    public function updateEvent($user, $task)
    {
        if (!$task->google_event_id) {
            // belum pernah dibuat di Google → buat baru
            return $this->createEvent($user, $task);
        }

        $service = $this->getClient($user);

        // Ambil event dulu lalu ubah field yang berubah
        $event = $service->events->get('primary', $task->google_event_id);
        $event->setSummary($task->title);
        $event->setDescription($task->description ?? '');

        $event->setStart([
            'dateTime' => date('c', strtotime($task->start_date)),
            'timeZone' => 'Asia/Jakarta',
        ]);
        $event->setEnd([
            'dateTime' => date('c', strtotime($task->end_date)),
            'timeZone' => 'Asia/Jakarta',
        ]);

        return $service->events->update('primary', $task->google_event_id, $event);
    }

    public function deleteEvent($user, $googleEventId)
    {
        if (!$googleEventId) return true;

        $service = $this->getClient($user);
        return $service->events->delete('primary', $googleEventId);
    }
}
