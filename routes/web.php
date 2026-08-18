<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Addfriends;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PrivateChatController;
use App\Http\Controllers\Groupchatcontroller;
use App\Http\Controllers\Groupprofile;
use App\Http\Controllers\Kickcontroller;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login.page');
})->name('logins');

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login');


/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('login.register');
})->name('register');

Route::post(
    '/register',
    [AuthController::class, 'register']
)->name('registers');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [AuthController::class, 'view']
)
    ->middleware('auth')
    ->name('main');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'view_profile']
    )->name('profile');

    Route::put(
        '/profile/edit/{id}',
        [ProfileController::class, 'input_data']
    )->name('profile.update');

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'checkrole'
])->group(function () {

    Route::get(
        '/admin',
        [AdminController::class, 'index']
    )->name('admin.page');

    Route::get(
        '/admin/edit/{id}',
        [AdminController::class, 'edit']
    )->name('users.edit');

    Route::post(
        '/admin/update/{id}',
        [AdminController::class, 'update']
    )->name('users.update');

    Route::post(
        '/admin/delete/{id}',
        [AdminController::class, 'delete']
    )->name('users.destroy');

});


/*
|--------------------------------------------------------------------------
| FRIEND
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post(
        '/addfriend',
        [Addfriends::class, 'addfriend']
    )->name('addfriend');

});


/*
|--------------------------------------------------------------------------
| PRIVATE CHAT
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post(
        '/open-chat',
        [PrivateChatController::class, 'openChat']
    )->name('chat.open');

    Route::post(
        '/send-message',
        [PrivateChatController::class, 'sendMessage']
    )->name('chat.send');

});


/*
|--------------------------------------------------------------------------
| GROUP
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Group page
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/group',
        [Groupchatcontroller::class, 'view']
    )->name('groupw.view');


    /*
    |--------------------------------------------------------------------------
    | Create group
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/create-group',
        [Groupchatcontroller::class, 'Create_group']
    )->name('group.create');


    /*
    |--------------------------------------------------------------------------
    | Open group chat
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/open-group-chat',
        [Groupchatcontroller::class, 'openGroupChat']
    )->name('group.open');


    /*
    |--------------------------------------------------------------------------
    | Send group message
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/send-group-message',
        [Groupchatcontroller::class, 'sendmessage']
    )->name('group.send');


    /*
    |--------------------------------------------------------------------------
    | Edit group
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/group/{id}/{group_name}/edit',
        [Groupchatcontroller::class, 'index_edit_group']
    )->name('group.edit');


    /*
    |--------------------------------------------------------------------------
    | Add members
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/group/update',
        [Groupchatcontroller::class, 'list_friend']
    )->name('group.update');


    /*
    |--------------------------------------------------------------------------
    | Remove member
    |--------------------------------------------------------------------------
    */

    Route::delete(
        '/group/remove-member',
        [Groupchatcontroller::class, 'removeMember']
    )->name('group.remove.member');

});


/*
|--------------------------------------------------------------------------
| OTHER
|--------------------------------------------------------------------------
*/

Route::get(
    '/main/profile/edit/{id}',
    [Groupprofile::class, 'index']
)->middleware('auth')
 ->name('attibutes');


Route::delete(
    '/main/remove_friend/{id}',
    [Kickcontroller::class, 'remove_friend']
)->middleware('auth')
 ->name('remove_friends');


Route::delete(
    '/main/remove_friend_from_group/{id}',
    [Kickcontroller::class, 'remove_from_group']
)->middleware('auth')
 ->name('remove_from_groups');

 Route::delete('/group/remove/{id}/{name}', [Kickcontroller::class, 'remove_group'] )
    ->name('remove_group');