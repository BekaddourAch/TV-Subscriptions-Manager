<?php
use \App\Http\Livewire\Backend\Admin\Customer\CustomerDetails;
use App\Http\Livewire\Backend\Admin\Customer\ListCustomers;
use App\Http\Livewire\Backend\Admin\Subscriptions\ListSubsctiptions;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Livewire\Backend\Admin\Dashboard\Dashboard;
use App\Http\Livewire\Backend\Admin\Users\ListPermissions;
use App\Http\Livewire\Backend\Admin\Users\ListRoles;
use App\Http\Livewire\Backend\Admin\Users\ListUsers;
use App\Http\Livewire\Backend\Admin\Services\ListServices;
use Illuminate\Support\Facades\URL;

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
App::setLocale('fr');
Route::get('/', function () {
   return redirect(route('admin.index'));
});

Route::get('/dashboard', function () {
    // return view('dashboard');
    return redirect(route('admin.index'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [BackendController::class, 'login'])->name('login');
    });

    Route::group(['middleware' => ['auth']], function (){
        Route::get('/', Dashboard::class)->name('index')->middleware("permission:statistics-display");
        Route::get('users', ListUsers::class)->name('users');
        Route::get('roles', ListRoles::class)->name('roles');
        Route::get('permissions', ListPermissions::class)->name('permissions');

        Route::get('customer', ListCustomers::class)->name('customers');
        Route::get('customer/{id}', CustomerDetails::class)->name('customer-details');
        Route::get('services', ListServices::class)->name('services');
        Route::get('subscriptions', ListSubsctiptions::class)->name('subscriptions');

    });
});


