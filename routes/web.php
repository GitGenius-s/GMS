<?php

use App\Http\Controllers\ListEmployeeController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/contact', function () {
    return view('contact');
}); // Equivalent to Route::get('/contact', 'ContactController@index'); , Route::view('/contact', 'contact');
Route::get('/about', function () {
    return view('about');
});

Route::get('employee.list', [ListEmployeeController::class,'listEmployee'])->name('employee.list'); // Equivalent to Route::get('customers', 'ListEmployeeController@listEmployee');
Route::post('pincode.add', [ListEmployeeController::class,'storePincode']);
Route::post('pincode.search', [ListEmployeeController::class,'searchPincode']);
Route::get('/pincode/{id}/edit', [ListEmployeeController::class, 'edit'])->name('pincode.edit');
Route::put('/pincode/{id}', [ListEmployeeController::class, 'update'])->name('pincode.update');
Route::delete('/pincode/{id}', [ListEmployeeController::class, 'deletePincode'])->name('pincode.delete');
