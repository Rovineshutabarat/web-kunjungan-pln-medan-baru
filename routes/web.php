<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\VisitorController;

Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login.process');
Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('adminpage')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('adminpage.dashboard.index')
        ->middleware('role:admin');

    Route::middleware('role:admin|officer')->group(function () {
        Route::get('/visit', [VisitController::class, 'index'])->name('adminpage.visit.index');
        Route::get('/visit/create', [VisitController::class, 'create'])->name('adminpage.visit.create');
        Route::post('/visit/store', [VisitController::class, 'store'])->name('adminpage.visit.store');
        Route::get('/visit/{id}/checkout', [VisitController::class, 'checkout'])->name('adminpage.visit.checkout');
        Route::get('/visit/{id}/update-status', [VisitController::class, 'updateStatus'])->name('adminpage.visit.update.status');
        Route::get('/visit/{id}/delete', [VisitController::class, 'destroy'])->name('adminpage.visit.destroy');
        Route::get('/visits/export-pdf', [VisitController::class, 'exportPdf'])->name('visit.export.pdf');
        Route::get('/visits/export-excel', [VisitController::class, 'exportExcel'])->name("visit.export.excel");



        Route::get('/visitor', [VisitorController::class, 'index'])->name('adminpage.visitor.index');
        Route::get('/visitor/{id}/delete', [VisitorController::class, 'destroy'])->name('adminpage.visitor.destroy');


        Route::get('/employee', [EmployeeController::class, 'index'])->name('adminpage.employee.index');
        Route::get('/employee/{id}/delete', [EmployeeController::class, 'destroy'])->name('adminpage.employee.destroy');
    });
});

Route::get("/", [MainController::class, 'index'])->name("index");
Route::get("/visit", [MainController::class, 'visit'])->name("visit");
Route::get('/visits/check-status', [MainController::class, 'checkStatus'])->name('visit.check');
Route::post("/visit/store", [MainController::class, 'createVisit'])->name("visit.create");
Route::get('/visit/success/{visit_id}', [MainController::class, 'showSuccess'])->name('visit.success');
