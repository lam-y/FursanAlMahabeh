<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('post', 'PostCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('contactmessage', 'ContactMessageCrudController');

    Route::get('export-members', [MemberController::class, 'export'])->name('export.members');
    Route::get('upgrade-members', [MemberController::class, 'upgradeMembers'])->name('upgrade-members');
}); // this should be the absolute last line of this file
