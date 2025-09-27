<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BlogCommentsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramOutlineController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingSlotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function (){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('manage-programs', [ProgramController::class, 'index'])->name('manage-programs');
    Route::get('manage-programs/create-program', [ProgramController::class, 'createProgram'])->name('manage-programs.create');
    Route::put('manage-programs/create/store', [ProgramController::class, 'storeProgramInformation'])->name('manage-programs.store');
    Route::get('manage-programs/create/add-image', [ProgramController::class, 'addProgramImage'])->name('manage-programs.create.add-image');
    Route::get('manage-students', [EnrollmentController::class, 'index'])->name('manage-students');
    Route::get('manage-blogs', [BlogController::class, 'manageBlogs'])->name('manage-blogs');
    Route::delete('manage-students/delete', [EnrollmentController::class, 'deleteTrainee'])->name('trainee.destroy');
    Route::post('manage-students/payment-fees', [PaymentTransactionController::class, 'makePayment'])->name('trainee.make_payment');
    Route::get('manage-programs/details', [ProgramController::class, 'show'])->name('show.program');
    Route::post('manage-programs/details/update-image', [ProgramController::class, 'updateProgramImage'])->name('program.update.image');
    Route::post('manage-programs/details/add-image', [ProgramController::class, 'storeProgramImage'])->name('program.store.image');
    Route::put('manage-programs/details/update-information', [ProgramController::class, 'updateProgramInformation'])->name('program.update.information');
    Route::put('manage-programs/details/update-outline', [ProgramOutlineController::class, 'updateOutline'])->name('program.update.outline');
    Route::post('manage-programs/details/create-outline', [ProgramOutlineController::class, 'storeOutline'])->name('program.create.outline');
    Route::get('manage-programs/details/add-outline', [ProgramOutlineController::class, 'createOutline'])->name('program.create.outline.view');
    Route::get('manage-blogs/details', [BlogController::class, 'showBlog'])->name('show.blog');
    Route::put('manage-blogs/details/update-information',[BlogController::class, 'updateInformation'])->name('blog.update.information');
    Route::delete('manage-blogs/details/tags/delete', [BlogController::class, 'deleteTag'])->name('blog.tag.delete');
    Route::get('manage-blogs/details/comments', [BlogCommentsController::class, 'showBlogComments'])->name('show.blog.comments');
    Route::put('manage-blogs/details/comments/update-status', [BlogCommentsController::class, 'updateCommentStatus'])->name('show.blog.comments.update.status');
    Route::get('manage-students/payments/view', [PaymentTransactionController::class, 'fetchPaymentTransactions'])->name('manage-students.view.payments');
    Route::get('manage-blogs/create-blog/view', [BlogController::class, 'createBlog'])->name('manage-blogs.create');
    Route::post('manage-blogs/create-blog', [BlogController::class, 'storeBlog'])->name('manage-blogs.store');
    Route::get('manage-blogs/create/upload-images', [BlogController::class, 'addBlogImage'])->name('manage-blogs.create.image');
    Route::post('manage-blogs/create-blog/upload-images', [BlogController::class, 'storeBlogImages'])->name('manage-blogs.upload-images');
    Route::post('manage-blogs/create-blog/upload-images/update', [BlogController::class, 'updateBlogImages'])->name('manage-blogs.upload-images.update');
    Route::delete('manage-blogs/delete', [BlogController::class, 'deleteBlog'])->name('manage-blogs.delete');
    Route::delete('manage-blog/details/comments/delete', [BlogCommentsController::class, 'destroyComment'])->name('show.blog.comments.delete');
    Route::delete('manage-blog/details/images/delete', [BlogController::class, 'destroyImage'])->name('show.blog.images.delete');
    Route::post('manage-blogs/comments/add', [BlogCommentsController::class, 'addComment'])->name('show.blog.comments.add');
    Route::delete('manage-programs/details/delete-outline', [ProgramOutlineController::class, 'deleteOutline'])->name('program.delete.outline');
    Route::delete('manage-programs/delete', [ProgramController::class, 'deleteProgram'])->name('manage-programs.delete');
    Route::delete('manage-blogs/images/delete', [BlogController::class, 'deleteImage'])->name('confirm-blog-image-deletion');
    Route::get('manage-subscribers', [SubscribersController::class, 'index'])->name('manage.subscribers');
    Route::get('manage-programs/training-slots', [TrainingSlotController::class, 'index'])->name('manage.training.slot.index');
    Route::post('manage-programs/training-slots/create-slot', [TrainingSlotController::class, 'store'])->name('manage.training.slot.store');
    Route::put('manage-programs/training-slots/update-slot', [TrainingSlotController::class, 'update'])->name('manage.training.slot.update');
    Route::delete('manage-programs/training-slots/delete-slot', [TrainingSlotController::class, 'destroy'])->name('manage.training.slot.destroy');
    Route::get('manage-students/view-information', [EnrollmentController::class, 'viewStudent'])->name('manage-students.view.info');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/training', [TrainingController::class, 'index'])->name('training');
Route::get('/training-detail', [TrainingController::class, 'show'])->name('show-training');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
Route::post('/submit-inquiry', [ContactController::class, 'submitRequest'])->name('on-inquire');
Route::get('/blog-detail', [BlogController::class, 'show'])->name('show-blog');
Route::post('/blog/create', [BlogCommentsController::class, 'createComment'])->name('create-comment');
Route::post('/programs/{slug}/enroll', [UserController::class, 'enrollStudent'])->name('enroll-student');
Route::get('/program-enrollment/verify-email', [UserController::class, 'completeEnrollment'])->name('complete-enrollment');
Route::post('manage-subscribers/add-subscriber', [SubscribersController::class, 'addMemberSubscription'])->name('manage.subscription.add');
Route::get('manage-subscribers/remove-subscriber', [SubscribersController::class, 'removeMemberSubscription'])->name('manage.subscription.remove');
Route::get('manage-subscribers/re-subscriber', [SubscribersController::class, 'resubscribe'])->name('manage.subscription.resubscribe');
Route::get('training/download-ebook', [TrainingController::class, 'downloadEbook'])->name('training.download.ebook');
Route::get('/payment/callback/{enrollment}', [UserController::class, 'paymentCallback'])->name('payment.callback');
Route::post('/fapshi/webhook', [WebhookController::class, 'handleFapshiWebhook'])->name('fapshi.webhook');
Route::get('/enrollment/status/{transactionId}', [WebhookController::class, 'checkPaymentStatus'])->name('enrollment.status');

require __DIR__.'/auth.php';
