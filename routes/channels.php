<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('board.{projectId}', function ($user, $projectId) {
    // Pastikan user punya akses ke project tersebut
    return true;
    // return $user->employee && $user->employee->projects->contains('id', $projectId);
});

Broadcast::channel('whiteboard.{boardId}', function ($user, $boardId) {
    // Atur policy sesuai kebutuhan; minimal user login
    return (bool) $user;
});
