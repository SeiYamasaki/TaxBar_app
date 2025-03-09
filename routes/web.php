<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TaxMinutesVideoController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('taxbarviews.login');
});
Route::get('/taxvideos', function () {
    return view('taxminivideos.index');
});

Route::view('/themes/detail', 'themes.detail')->name('themes.detail');

Route::get('/taxminivideos', [TaxMinutesVideoController::class, 'index'])->name('taxminivideos.index');
Route::get('/taxminivideos/prefecture/{prefecture}', [TaxMinutesVideoController::class, 'byPrefecture'])->name('taxminivideos.prefecture');
Route::get('/taxminivideos/{video}', [TaxMinutesVideoController::class, 'show'])->name('taxminivideos.show');

Route::get('/view/hachimantaishi', function () {
    return view('taxbarviews.hachimantaishi');
});
Route::get('/view/prohibited', function () {
    return view('taxbarviews.prohibited');
});
Route::get('/inquiry', [InquiryController::class, 'showForm'])->name('inquiry.form');
Route::post('/inquiry/confirm', [InquiryController::class, 'confirm'])->name('inquiry.confirm');
Route::post('/inquiry/send', [InquiryController::class, 'sendInquiry'])->name('inquiry.send');
Route::post('/stripe-payment', [PaymentController::class, 'createPayment'])->name('stripe.payment');
Route::get('/view/theme', [ThemeController::class, 'show']); // テーマルート

Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');  // ✅ 誰でも見れるようにする

Route::get('/faq', [FaqController::class, 'index'])->name('faqs.index');

Route::get('/register/select', function () { //登録フォーム
    return view('auth.register_select');
})->name('register.select');

Route::get('/register/tax-expert', [RegisterController::class, 'showTaxExpertRegister'])->name('register.tax_expert'); //登録フォーム
Route::post('/register/tax-expert', [RegisterController::class, 'registerTaxExpert'])->name('register.tax_expert.post'); //登録処理

Route::get('/register/company', [RegisterController::class, 'showCompanyRegister'])->name('register.company'); //登録フォーム
Route::post('/register/company', [RegisterController::class, 'registerCompany'])->name('register.company.post'); //登録処理

Route::get('/register/individual', [RegisterController::class, 'showIndividualRegister'])->name('register.individual'); //登録フォーム
Route::post('/register/individual', [RegisterController::class, 'registerIndividual'])->name('register.individual.post'); //登録処理

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証が必要なTaxMinutesビデオ管理ルート
Route::middleware(['auth'])->group(function () {
    Route::post('/taxminivideos', [TaxMinutesVideoController::class, 'store'])->name('taxminivideos.store');
    Route::get('/taxminivideos/{video}/edit', [TaxMinutesVideoController::class, 'edit'])->name('taxminivideos.edit');
    Route::put('/taxminivideos/{video}', [TaxMinutesVideoController::class, 'update'])->name('taxminivideos.update');
    Route::delete('/taxminivideos/{video}', [TaxMinutesVideoController::class, 'destroy'])->name('taxminivideos.destroy');
});
//特集ページルート
Route::get('/special', function () {
    return view('special_pages.index');
});
require __DIR__ . '/auth.php';
