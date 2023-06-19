<?php

use App\Http\Controllers\Auth\LoginController;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/test-mail', function (Request $request) {
//     $email = $request->email ??  config('app.email');

//     $sent =  Mail::to($email)->send(new TestMail());

//     return response(
//         ['status' => $sent ? 'success' : 'fail'],
//     );
// });

Route::post('/language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'fr', 'sw'])) {
        abort(400);
    }
    App::setLocale($locale);
    Session::put('locale', $locale);
    if (auth()->user()) {
        $user = User::where('id', auth()->user()->id)->first();
        $user->language = $locale;
        $user->save();
    }

    return redirect()->back();
})->name('language-switcher');

Route::get('/graphql', function (Request $request) {
    return view('vendor/graphiql/index');
})->middleware('admin')->name('v1.graphql-web');

Route::get('/{any?}', [\App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*')->name('home');