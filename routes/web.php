<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ウェルカムページを表示するルート
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボードページのルート定義
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証済みユーザー向けのグループ化されたルート
Route::middleware('auth')->group(function () {
    // ユーザープロフィールの編集ページへのルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // ユーザープロフィールの更新を行うルート
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ユーザープロフィールの削除を行うルート
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 外部の認証関連のルートを読み込む
require __DIR__ . '/auth.php';