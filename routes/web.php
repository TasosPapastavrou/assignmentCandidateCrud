<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/get/job/applied',[App\Http\Controllers\CandidateController::class,'getJobAppliedFor'])->name('get.job.applied');
Route::get('/get/degrees',[App\Http\Controllers\CandidateController::class,'getDegrees'])->name('get.degrees');


Route::get('/', [App\Http\Controllers\CandidateController::class,'showForm'])->name('home.page');
Route::post('/get/candidate/datatables',[App\Http\Controllers\CandidateController::class,'applicationDataTables'])->name('get.candidate.datatables');


Route::get('/candidate/form',[App\Http\Controllers\CandidateController::class,'ApplicationForm'])->name('form.candidate');
Route::get('/degree/form',[App\Http\Controllers\CandidateController::class,'degreeForm'])->name('form.degree');


Route::post('/store/degree',[App\Http\Controllers\CandidateController::class,'storeDegree'])->name('store.degree');
Route::post('/store/application',[App\Http\Controllers\CandidateController::class,'storeApplication'])->name('store.application');


Route::get('/delete/candidate/{id}',[App\Http\Controllers\CandidateController::class,'applicationDelete'])->name('delete.candidate');


Route::get('/edit/candidate/{id}',[App\Http\Controllers\CandidateController::class,'editApplicationForm'])->name('edit.candidatet');
Route::post('/edit/candidate/update/{id}',[App\Http\Controllers\CandidateController::class,'editApplication'])->name('edit.candidates.update');


Route::get('/delete-pdf/{id}', [App\Http\Controllers\CandidateController::class,'deletePdf'])->name('delete.pdf');






