<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SsrController;
use App\Http\Controllers\SsaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	/*Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');


	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');*/

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');

    //AGESB Routes start here
    Route::prefix('ssr')->name('ssr.')->group(function(){
        //SSR->Request routes here
        Route::get('/request',[SsrController::class,'index'])->name('request.index');
        Route::get('/request/create',[SsrController::class,'create'])->name('request.create');
        Route::post('/request/store',[SsrController::class, 'store'])->name('request.store');
        Route::get('/request/edit/{ssr}', [SsrController::class, 'edit'])->name('request.edit');
        Route::put('/request/update/{ssr}',[SsrController::class, 'update'])->name('request.update');
        Route::get('/request/show/{ssr}', [SsrController::class, 'show'])->name('request.show');

        //SSR->Verification routes here
        Route::get('/verify',[SsrController::class, 'verifyIndex'])->name('verify.index');
        Route::get('/verify/edit/{ssr}', [SsrController::class, 'verifyEdit'])->name('verify.edit');
        Route::put('/verify/update/{ssr}', [SsrController::class, 'verifyUpdate'])->name('verify.update');
        Route::get('/verify/show/{ssr}', [SsrController::class, 'verifyShow'])->name('verify.show');

        //SSR->Approval routes here
        Route::get('/approve',[SsrController::class, 'approveIndex'])->name('approve.index');
        Route::get('/approve/edit/{ssr}', [SsrController::class, 'approveEdit'])->name('approve.edit');
        Route::put('/approve/update/{ssr}', [SsrController::class, 'approveUpdate'])->name('approve.update');
        Route::get('/approve/show/{ssr}', [SsrController::class, 'approveShow'])->name('approve.show');

        //SSR->Export pdf routes here
        Route::get('/report/export/{ssr}',[SsrController::class, 'exportReport'])->name('report.export');
        Route::get('/report',[SsrController::class, 'reportIndex'])->name('report.index');
        Route::get('/report/summary', [SsrController::class, 'exportSummary'])->name('report.summary');
    });

    Route::prefix('ssa')->name('ssa.')->group(function(){
        //SSA->Request routes here
        Route::get('/request',[SsaController::class,'index'])->name('request.index');
        Route::get('/request/create',[SsaController::class,'create'])->name('request.create');
        Route::post('/request/store',[SsaController::class, 'store'])->name('request.store');
        Route::get('/request/edit/{ssa}', [SsaController::class, 'edit'])->name('request.edit');
        Route::put('/request/update/{ssa}',[SsaController::class, 'update'])->name('request.update');
        Route::get('/request/show/{ssa}', [SsaController::class, 'show'])->name('request.show');

        //SSR->Verification routes here
        Route::get('/verify',[SsaController::class, 'verifyIndex'])->name('verify.index');
        Route::get('/verify/edit/{ssa}', [SsaController::class, 'verifyEdit'])->name('verify.edit');
        Route::put('/verify/update/{ssa}', [SsaController::class, 'verifyUpdate'])->name('verify.update');
        Route::get('/verify/show/{ssa}', [SsaController::class, 'verifyShow'])->name('verify.show');

        //SSR->Approval routes here
        Route::get('/approve',[SsaController::class, 'approveIndex'])->name('approve.index');
        Route::get('/approve/edit/{ssa}', [SsaController::class, 'approveEdit'])->name('approve.edit');
        Route::put('/approve/update/{ssa}', [SsaController::class, 'approveUpdate'])->name('approve.update');
        Route::get('/approve/show/{ssa}', [SsaController::class, 'approveShow'])->name('approve.show');

        //SSR->Export pdf routes here
        Route::get('/report/export/{ssa}',[SsaController::class, 'exportReport'])->name('report.export');
        Route::get('/report',[SsaController::class, 'reportIndex'])->name('report.index');
        Route::get('/report/summary', [SsaController::class, 'exportSummary'])->name('report.summary');
    });

    Route::prefix('pr')->name('pr.')->group(function(){
        //PR->Request routes here
        Route::get('/request', [PurchaseRequestController::class, 'index'])->name('request.index');
        Route::get('/request/create',[PurchaseRequestController::class, 'create'])->name('request.create');
        Route::post('/request/store/', [PurchaseRequestController::class, 'store'])->name('request.store');
        Route::get('/request/edit/{pr}',[PurchaseRequestController::class, 'edit'])->name('request.edit');
        Route::put('/request/update/{pr}', [PurchaseRequestController::class, 'update'])->name('request.update');
        Route::get('/request/show/{pr}', [PurchaseRequestController::class, 'show'])->name('request.show');


        //PR->Confirm routes here
        Route::get('/confirm', [PurchaseRequestController::class, 'confirmIndex'])->name('confirm.index');
        Route::get('/confirm/edit/{pr}', [PurchaseRequestController::class, 'confirmEdit'])->name('confirm.edit');
        Route::put('/confirm/update/{pr}', [PurchaseRequestController::class, 'confirmUpdate'])->name('confirm.update');
        Route::get('/confirm/show/{pr}', [PurchaseRequestController::class, 'show'])->name('confirm.show');


        //PR->Approve routes here
        Route::get('/approve', [PurchaseRequestController::class, 'approveIndex'])->name('approve.index');
        Route::get('/approve/edit/{pr}', [PurchaseRequestController::class, 'approveEdit'])->name('approve.edit');
        Route::put('/approve/update/{pr}', [PurchaseRequestController::class, 'approveUpdate'])->name('approve.update');

        //PR->Report routes here
        Route::get('/report', [PurchaseRequestController::class, 'reportIndex'])->name('report.index');
        Route::get('/report/export/{pr}', [PurchaseRequestController::class, 'exportReport'])->name('report.export');
        Route::get('/report/summary', [PurchaseRequestController::class, 'exportSummary'])->name('report.summary');
    });
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
