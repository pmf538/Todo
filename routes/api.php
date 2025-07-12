<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les commandes
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::put('/{order}', [OrderController::class, 'update']);
    Route::delete('/{order}', [OrderController::class, 'destroy']);
    Route::post('/{order}/validate', [OrderController::class, 'validateOrder']);
    Route::post('/{order}/deliver', [OrderController::class, 'markAsDelivered']);
    Route::get('/customer/{customer}', [OrderController::class, 'getByCustomer']);
});

// Routes pour les produits
Route::get('/products', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Product::with('category')->get()
    ]);
});

Route::get('/products/low-stock', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Product::whereRaw('stock <= stock_alert_threshold')->with('category')->get()
    ]);
});

// Routes pour les clients
Route::get('/customers', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Customer::all()
    ]);
});

// Routes pour les catégories
Route::get('/categories', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Category::with('products')->get()
    ]);
});

// Statistiques du dashboard
Route::get('/dashboard/stats', function () {
    $stats = [
        'total_orders' => \App\Models\Order::count(),
        'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
        'low_stock_products' => \App\Models\Product::whereRaw('stock <= stock_alert_threshold')->count(),
        'orders_by_status' => \App\Models\Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray(),
    ];

    return response()->json([
        'success' => true,
        'data' => $stats
    ]);
}); 