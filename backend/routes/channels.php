<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('post', function ($user) {
    return $user;
});

Broadcast::channel('comment', function ($user) {
    return $user;
});

Broadcast::channel('like', function ($user) {
    return $user;
});

Broadcast::channel('notification.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
