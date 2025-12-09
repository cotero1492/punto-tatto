<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PublicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::prefix('public')->group(function () {
    Route::get('/artists', [PublicController::class, 'getArtists']);
    Route::get('/artists/{id}', [PublicController::class, 'getArtistProfile']);
    Route::get('/styles', [PublicController::class, 'getStyles']);
});

// Autenticación
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

// Rutas protegidas - Artista
Route::prefix('artist')->middleware(['auth:sanctum', 'role:artist'])->group(function () {
    Route::get('/dashboard', [ArtistController::class, 'dashboard']);
    Route::get('/profile', [ArtistController::class, 'getProfile']);
    Route::put('/profile', [ArtistController::class, 'updateProfile']);
    Route::post('/profile/photo', [ArtistController::class, 'uploadPhoto']);
    
    // Galería
    Route::apiResource('gallery', GalleryController::class);
    
    // Mensajes
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{conversation}', [MessageController::class, 'show']);
    Route::post('/messages', [MessageController::class, 'store']);
    
    // Estadísticas
    Route::get('/statistics', [ArtistController::class, 'statistics']);
    
    // Membresía
    Route::get('/membership', [ArtistController::class, 'getMembership']);
    Route::post('/membership/subscribe', [PaymentController::class, 'subscribe']);
    Route::post('/membership/cancel', [PaymentController::class, 'cancelSubscription']);
});

// Rutas protegidas - Cliente
Route::prefix('client')->middleware(['auth:sanctum', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard']);
    Route::get('/profile', [ClientController::class, 'getProfile']);
    Route::put('/profile', [ClientController::class, 'updateProfile']);
    
    // Favoritos
    Route::get('/favorites', [ClientController::class, 'getFavorites']);
    Route::post('/favorites/{artist}', [ClientController::class, 'addFavorite']);
    Route::delete('/favorites/{artist}', [ClientController::class, 'removeFavorite']);
    
    // Mensajes
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{conversation}', [MessageController::class, 'show']);
    Route::post('/messages', [MessageController::class, 'store']);
    
    // Reseñas
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});

// Rutas protegidas - Administrador
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Gestión de artistas
    Route::get('/artists', [AdminController::class, 'indexArtists']);
    Route::get('/artists/{id}', [AdminController::class, 'showArtist']);
    Route::put('/artists/{id}/verify', [AdminController::class, 'verifyArtist']);
    Route::put('/artists/{id}/suspend', [AdminController::class, 'suspendArtist']);
    
    // Gestión de clientes
    Route::get('/clients', [AdminController::class, 'indexClients']);
    Route::get('/clients/{id}', [AdminController::class, 'showClient']);
    
    // Gestión de membresías
    Route::get('/memberships', [AdminController::class, 'getMemberships']);
    Route::put('/memberships/{id}', [AdminController::class, 'updateMembership']);
    
    // Pagos
    Route::get('/payments', [AdminController::class, 'getPayments']);
    Route::get('/payments/{id}', [AdminController::class, 'getPayment']);
    
    // Publicidad
    Route::get('/advertisements', [AdminController::class, 'indexAdvertisements']);
    Route::post('/advertisements', [AdminController::class, 'storeAdvertisement']);
    Route::put('/advertisements/{id}', [AdminController::class, 'updateAdvertisement']);
    Route::delete('/advertisements/{id}', [AdminController::class, 'destroyAdvertisement']);
    
    // Ranking
    Route::get('/ranking/config', [AdminController::class, 'getRankingConfig']);
    Route::post('/ranking/recalculate', [AdminController::class, 'recalculateRanking']);
    
    // Reportes
    Route::get('/reports/users', [AdminController::class, 'usersReport']);
    Route::get('/reports/payments', [AdminController::class, 'paymentsReport']);
    
    // Reseñas
    Route::put('/reviews/{id}/approve', [AdminController::class, 'approveReview']);
    Route::delete('/reviews/{id}/reject', [AdminController::class, 'rejectReview']);
});

// Webhooks de OpenPay
Route::prefix('webhooks')->group(function () {
    Route::post('/openpay', [PaymentController::class, 'handleWebhook']);
});

