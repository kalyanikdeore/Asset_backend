<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ProductInquiryController;



Route::post('/contact-forms', [ContactFormController::class, 'store']);

Route::post('/product-inquiry', [ProductInquiryController::class, 'store']);







// // Contact Form Routes
// Route::get('/contact-forms', [ContactFormController::class, 'index']); // GET route to list/fetch contact forms
// Route::post('/contact-forms', [ContactFormController::class, 'store']); // POST route to create new contact form

// // Product Inquiry Routes
// Route::get('/product-inquiry', [ProductInquiryController::class, 'index']); // GET route to list/fetch inquiries
// Route::post('/product-inquiry', [ProductInquiryController::class, 'store']); // POST route to create new inquiry