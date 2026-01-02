<?php

use App\Http\Controllers\Site\UserController;
use Illuminate\Support\Facades\Route;



///////////////users////////////////////////////////////////////////
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/bank_accounts', [UserController::class, 'userBankAccounts']);
    Route::get('/questions', [UserController::class, 'userQuestions']);
    Route::put('/update', [UserController::class, 'update']);
    Route::get('contracts', [UserController::class, 'user_contracts']);
    Route::get('contract-list', [UserController::class, 'user_contract_list']);
    Route::get('payments', [UserController::class, 'userPayments']);
    Route::get('tickets', [UserController::class, 'userTickets']);
    Route::get('transactions', [UserController::class, 'userTransactions']);
    Route::get('inventory', [UserController::class, 'user_inventory']);
    Route::get('/files', [UserController::class, 'userFiles']);
    Route::post('/store_file', [UserController::class, 'store_file']);
    Route::get('/settlements', [UserController::class, 'userSettlements']);
    Route::get('/ads', [UserController::class, 'ads']);
