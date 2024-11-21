<?php

use App\Http\Controllers\AutoAssignmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustryPartnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Models\IndustryPartner;
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

Route::post('/auto-assign', [AutoAssignmentController::class, 'autoAssign'])->name('auto-assign');
Route::resource('projects', AutoAssignmentController::class);

Route::get('/', [IndustryPartnerController::class, 'index'])->name('home');
Route::get('/industry-partners/approval-menu', [IndustryPartnerController::class, 'unapproved'])->middleware('checkIfTeacher')->name('industry-partners.unapproved');
Route::put('/industry-partners/approve/{id}', [IndustryPartnerController::class, 'approve'])->name('industry-partners.approve');
Route::resource('industry-partners', IndustryPartnerController::class);

Route::get('/create-project', [ProjectController::class, 'create'])->middleware('checkIfInP', 'checkApproval');
Route::get('/projects/{id}/apply', [ProjectController::class, 'apply'])->middleware('checkIfStudent');
Route::post('/application/{id}', [ProjectController::class, 'storeApplication']);
Route::resource('projects', ProjectController::class);

Route::get('students/{id}', [StudentController::class, 'show'])->middleware(['checkIfStudentOrTeacher'])->name('students.show');
Route::resource('students', StudentController::class);
Route::get('students/', [StudentController::class, 'index'])->middleware('checkIfTeacher')->name('students.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
