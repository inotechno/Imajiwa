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

Broadcast::channel('whiteboard.{boardId}', fn() => true);


// Broadcast::channel('board.{boardId}', function ($user, $boardId) {
//     // pastikan User/Employee model dan relasi project membership ada
//     // return true jika user boleh mengakses board
//     // contoh: cek apakah user employee tergabung di project board
//     return \App\Models\ProjectBoard::where('id', $boardId)
//             ->whereHas('project', fn($q) => $q->whereHas('employees', fn($q2) => $q2->where('employees.id', $user->id)))
//             ->exists();
// });
