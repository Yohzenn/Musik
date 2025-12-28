<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    dd('test');
});

Route::middleware('api.key')->get('/playlists', function (Request $request) {
    return $request->user()->playlists()->with('tracks')->get();
});
