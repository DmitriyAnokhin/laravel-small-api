## laravel-small-api

Пример api с jwt авторизацией на основе пакета https://github.com/tymondesigns/jwt-auth

#### Методы без авторизации

    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);

#### Методы с авторизацией

Запросы должны содержать заголовок Authorization Bearer {token}

    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::put('profile', [ProfileController::class, 'update']);
    Route::get('profile', [ProfileController::class, 'read']);

    Route::post('orders', [OrderController::class, 'create']);
    Route::get('orders', [OrderController::class, 'list']);
    Route::get('orders/{id}', [OrderController::class, 'read']);
    Route::put('orders/{id}/canceled', [OrderController::class, 'canceled']);
    Route::put('orders/{id}/completed', [OrderController::class, 'completed']);

    Route::post('orders/{order_id}/demands', [DemandController::class, 'create']);
    Route::get('orders/{order_id}/demands', [DemandController::class, 'list']);
    Route::put('orders/{order_id}/demands/{id}/accept', [DemandController::class, 'accept']);
    Route::put('orders/{order_id}/demands/{id}/canceled', [DemandController::class, 'canceled']);

    Route::post('demands/{demand_id}/reviews', [ReviewController::class, 'create']);
    Route::get('reviews/user/{user_id}', [ReviewController::class, 'list']);

