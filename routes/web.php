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
use App\Http\Controllers\SouzokuTaxController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaxAdvisorController;
use App\Http\Controllers\TaxAdvisorProfileController;



Route::get('/', function () {
    return view('taxbarviews.login');
});
Route::get('/taxvideos', function () {
    return view('taxminivideos.index');
});

Route::view('/themes/detail', 'themes.detail')->name('themes.detail');

Route::get('/taxminivideos', [TaxMinutesVideoController::class, 'index'])->name('taxminivideos.index');
Route::get('/taxminivideos/prefecture/{prefecture}', [TaxMinutesVideoController::class, 'byPrefecture'])->name('taxminivideos.prefecture');
// 認証不要の一般公開用動画詳細表示ルート
Route::get('/taxminivideos/view/{video}', [TaxMinutesVideoController::class, 'show'])->name('taxminivideos.show');

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
Route::post('/stripe-webhook', [PaymentController::class, 'handleWebhook'])->name('stripe.webhook');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
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

    // 税理士プロフィール編集ルート
    Route::get('/tax-advisor/profile', [TaxAdvisorProfileController::class, 'edit'])->name('tax_advisor.profile.edit');
    Route::patch('/tax-advisor/profile', [TaxAdvisorProfileController::class, 'update'])->name('tax_advisor.profile.update');
});

// コメント投稿ルート（認証不要）
Route::post('/taxminivideos/{video}/comments', [CommentController::class, 'storeForVideo'])->name('comments.store.video');
Route::post('/themes/{theme}/comments', [CommentController::class, 'storeForTheme'])->name('comments.store.theme');

// 認証が必要なTaxMinutesビデオ管理ルート
Route::middleware(['auth'])->group(function () {
    // 固定パスのルートを先に定義
    Route::get('/taxminivideos/manage', [TaxMinutesVideoController::class, 'manage'])->name('taxminivideos.manage');

    Route::post('/taxminivideos', [TaxMinutesVideoController::class, 'store'])->name('taxminivideos.store');
    Route::get('/taxminivideos/{video}/edit', [TaxMinutesVideoController::class, 'edit'])->name('taxminivideos.edit');
    Route::put('/taxminivideos/{video}', [TaxMinutesVideoController::class, 'update'])->name('taxminivideos.update');
    Route::delete('/taxminivideos/{video}', [TaxMinutesVideoController::class, 'destroy'])->name('taxminivideos.destroy');

    // コメント関連のルート（認証が必要）
    Route::get('/comments/my', [CommentController::class, 'myComments'])->name('comments.my');
    Route::get('/comments/received', [CommentController::class, 'receivedComments'])->name('comments.received');
    Route::put('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::put('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// 管理者向けコメント管理ルート
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/comments', [CommentController::class, 'index'])->name('admin.comments.index');
    Route::post('/comments/bulk-approve', [CommentController::class, 'bulkApprove'])->name('admin.comments.bulk.approve');
    Route::delete('/comments/bulk-delete', [CommentController::class, 'bulkDelete'])->name('admin.comments.bulk.delete');
});

//特集ページルート
Route::get('/special', function () {
    return view('special_pages.index');
});

// 相続ページルート定義
Route::get('/souzoku-tax', [SouzokuTaxController::class, 'index']);

// 税理士一覧関連のルート
Route::get('/tax-advisors', function () {
    return view('tax-advisors');
})->name('tax-advisors');

// 都道府県ごとの税理士一覧ページ
Route::get('/tax-advisors/prefecture/{prefecture}', [TaxAdvisorController::class, 'byPrefecture'])->name('tax-advisors.prefecture');

// 税理士プロフィール詳細ページ（認証不要）
Route::get('/tax-advisor/{id}', [TaxAdvisorProfileController::class, 'show'])->name('tax-advisors.show');

//3Dページルート
Route::get('/about-taxbar', function () {
    return view('taxbar');
});

//3Dページから入店後のルート
Route::get('/taxbar-introduction', function () {
    return view('taxbar-introduction');
})->name('taxbar-introduction');  // ここで名前を付ける

require __DIR__ . '/auth.php';
