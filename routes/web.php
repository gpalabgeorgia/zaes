<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestController;



Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->namespace('Admin')->group(function() {
    // All the admin routes will be defined here
    Route::match(['get', 'post'],'/', [AdminController::class, 'login']);

    Route::group(['middleware'=>['admin']], function() {

        Route::get('dashboard', [AdminController::class, 'dashboard']);

        Route::get('settings', [AdminController::class, 'settings']);

        Route::get('logout', [AdminController::class, 'logout']);

        Route::post('check-current-pwd', [AdminController::class, 'chkCurrentPassword']);

        Route::post('update-current-pwd', [AdminController::class, 'updateCurrentPassword']);

        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails']);

        // Sections
        Route::get('sections', [SectionsController::class, 'sections']);
        Route::post('update-section-status', [SectionsController::class, 'updateSectionsStatus']);

        // Categories
        Route::get('categories', [CategoryController::class, 'categories']);
        Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);
        Route::post('append-categories-level', [CategoryController::class, 'appendCategoryLevel']);
        Route::get('delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);
        Route::get('delete-category/{id}', [CategoryController::class, 'deleteCategory']);

        // Products
        Route::get('products', [ProductController::class, 'products']);
        Route::post('update-product-status', [ProductController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}', [ProductController::class, 'deleteProduct']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}', [ProductController::class, 'addEditProduct']);
    });
    
});