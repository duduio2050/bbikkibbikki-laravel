<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/register',function (Request $request) {
    User::create([
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
        'name' => $request->input('name')
    ]);
    return response()->json(['message'=>'success'],200);
});


// 토큰 발급
Route::post('/user/createToken', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    // createToken의 인자는 token table의 name 컬럼 값에 저장된다.
    return "토큰 생성 : ". $user->createToken('token-name')->plainTextToken;
});

Route::middleware(['api'])->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user/{id}', [UserController::class, 'show'])->name("user.show");
    });
});
