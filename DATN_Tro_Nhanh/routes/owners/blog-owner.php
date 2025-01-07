<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owners\BlogOwnersController;

Route::group(['prefix' => ''], function () {
    route::get('quan-ly-blog', [BlogOwnersController::class, 'show'])->name('show-blog');
    route::get('them-blog', [BlogOwnersController::class, 'index'])->name('blog');
    // Route::delete('xoa/{slug}', [BlogOwnersController::class, 'destroy'])->name('xoa-blog');
    Route::delete('/xoa-blog/{id}', [BlogOwnersController::class, 'destroy'])->name('destroy-blog');
    Route::put('/khoi-phuc-blog/{id}', [BlogOwnersController::class, 'restore'])->name('restore-blog');
    Route::get('/thung-rac-blog', [BlogOwnersController::class, 'trash'])->name('trash-blog');
    Route::post('/xoa-bog-duoc-chon', [BlogOwnersController::class, 'deleteMultiple'])->name('delete-multiple');
    Route::get('sua-blog/{id}', [BlogOwnersController::class, 'editBlog'])->name('sua-blog');
    Route::put('/sua-bai-viet/{id}', [BlogOwnersController::class, 'updateBlog'])->name('update-blog');

    route::post('them-blog', [BlogOwnersController::class, 'store'])->name('create-blog');
    Route::post('/upload-image', [BlogOwnersController::class, 'uploadImage'])->name('upload-image');
    Route::delete('/blogs/{id}/force-delete', [BlogOwnersController::class, 'forceDelete'])->name('force-delete-blog');
    // Route::get('nhan-tong', [BlogOwnersController::class, 'show'])->name('show-fix');
});