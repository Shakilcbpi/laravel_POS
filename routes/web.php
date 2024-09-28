<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
//use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;

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
    return view('welcome');
});

//API routes
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'userLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware(TokenVerificationMiddleware::class);
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware(TokenVerificationMiddleware::class);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware(TokenVerificationMiddleware::class);


//Logout
Route::get('/logout',[UserController::class,'userLogout']);


//Page routes

//Route::get('/',[UserController::class,'HomePage']);
Route::get('/',[HomeController::class,'HomePage']);
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOtpPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
//Cusotmer 
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
//Invoice
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoiceDetail',[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);



//Customer API 
Route::post('/create-customer',[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-customer',[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer',[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-customer',[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-d',[CustomerController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);

//Category API

Route::post('/create-category',[CategoryController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-category',[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-category',[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-category',[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-by-id',[CategoryController::class,'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);
//Product API

Route::post('/create-product',[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-product',[ProductController::class,'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/product-by-id',[ProductController::class,'ProductByID'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-product',[ProductController::class,'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-product',[ProductController::class,'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);

//Invoice API

Route::post('/invoice-create',[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-select',[InvoiceController::class,'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoice-delete',[InvoiceController::class,'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);
// SUMMARY & Report
Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerificationMiddleware::class]);

//