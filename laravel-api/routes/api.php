<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentRegistration;
use Illuminate\Http\Request;

// Route::middleware(['auth:sanctum'])->group(function () {
    
// });





Route::get('login', function () {
    return "I m login page";
});

Route::get('add', function () {
    return "I m registartion page";
});





Route::get('all', [StudentRegistration::class, 'FindAll']);

Route::get('find/{id}', [StudentRegistration::class, 'FindStudent']); // GET /api/students/1




Route::post('add', [StudentRegistration::class, 'AddStudent']); // POST /api/students Route::post('students', [StudentRegistration::class, 'AddStudent']); // POST /api/students


Route::delete('{id}', [StudentRegistration::class, 'DeleteStudent']); // DELETE /api/students/1

Route::put('{id}', [StudentRegistration::class, 'UpdateStudent']); // PUT /api/students/1
Route::post('login', [StudentRegistration::class, 'login']);// PUT /api/students/1

Route::post('logout', [StudentRegistration::class, 'logout'])->name('logout');


