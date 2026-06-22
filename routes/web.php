<?php

use App\Http\Controllers\InvoicePdfController;
use App\Livewire\InvoiceForm;
use App\Livewire\InvoiceList;
use App\Livewire\InvoiceShow;
use Illuminate\Support\Facades\Route;

Route::get('/', InvoiceForm::class)->name('home');
Route::get('/invoices', InvoiceList::class)->name('invoices.index');
Route::get('/invoices/{invoice}', InvoiceShow::class)->name('invoices.show');
Route::get('/invoices/{invoice}/pdf', InvoicePdfController::class)->name('invoices.pdf');
