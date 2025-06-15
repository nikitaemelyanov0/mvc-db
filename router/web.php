<?php

Route::get('/', [MainController::class, 'indexGet']);

Route::get('/registeration', [UserController::class, 'registerationGet']);
Route::post('/registeration', [UserController::class, 'registerationPost']);

Route::get('/authorization', [UserController::class, 'authorizationGet']);
Route::post('/authorization', [UserController::class, 'authorizationPost']);

Route::get('/changeinfo', [UserController::class, 'changeinfoGet']);
Route::post('/changeinfo', [UserController::class, 'changeinfoPost']);

Route::get('/calc-ndfl', [TestController::class, 'ndflGet']);
Route::post('/calc-ndfl', [TestController::class, 'ndflPost']);