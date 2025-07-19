<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'departments')->name('departments');
Route::view('/employees', 'employees')->name('employees');
Route::view('/attendances', 'attendances')->name('attendances');
Route::view('/checkin', 'checkin')->name('checkin');
Route::view('/checkout', 'checkout')->name('checkout');
