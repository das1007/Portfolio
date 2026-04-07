<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;

Route::get('/',         [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.send');

Route::get('/admin/login',  [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(\App\Http\Middleware\AdminAuthMiddleware::class)->prefix('admin')->group(function () {
    Route::get('/',        [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');

    // Contacts
    Route::get('/contacts',                  [AdminController::class, 'contacts'])->name('admin.contacts');
    Route::get('/contacts/{contact}',        [AdminController::class, 'showContact'])->name('admin.contact.show');
    Route::patch('/contacts/{contact}',      [AdminController::class, 'updateContact'])->name('admin.contact.update');
    Route::delete('/contacts/{contact}',     [AdminController::class, 'destroyContact'])->name('admin.contact.destroy');

    // Experience
    Route::get('/experiences',               [AdminController::class, 'experiences'])->name('admin.experiences');
    Route::post('/experiences',              [AdminController::class, 'storeExperience'])->name('admin.experience.store');
    Route::patch('/experiences/{experience}',[AdminController::class, 'updateExperience'])->name('admin.experience.update');
    Route::delete('/experiences/{experience}',[AdminController::class,'destroyExperience'])->name('admin.experience.destroy');

    // Education
    Route::get('/educations',                [AdminController::class, 'educations'])->name('admin.educations');
    Route::post('/educations',               [AdminController::class, 'storeEducation'])->name('admin.education.store');
    Route::patch('/educations/{education}',  [AdminController::class, 'updateEducation'])->name('admin.education.update');
    Route::delete('/educations/{education}', [AdminController::class, 'destroyEducation'])->name('admin.education.destroy');

    // Skills
    Route::get('/skills',                    [AdminController::class, 'skills'])->name('admin.skills');
    Route::post('/skills',                   [AdminController::class, 'storeSkill'])->name('admin.skill.store');
    Route::patch('/skills/{skill}',          [AdminController::class, 'updateSkill'])->name('admin.skill.update');
    Route::delete('/skills/{skill}',         [AdminController::class, 'destroySkill'])->name('admin.skill.destroy');

    // Upwork Reviews
    Route::get('/upwork-reviews',            [AdminController::class, 'upworkReviews'])->name('admin.upwork');
    Route::post('/upwork-reviews',           [AdminController::class, 'storeReview'])->name('admin.upwork.store');
    Route::patch('/upwork-reviews/{review}', [AdminController::class, 'updateReview'])->name('admin.upwork.update');
    Route::delete('/upwork-reviews/{review}',[AdminController::class, 'destroyReview'])->name('admin.upwork.destroy');

    // Projects (NEW)
    Route::get('/projects',                  [AdminController::class, 'projects'])->name('admin.projects');
    Route::post('/projects',                 [AdminController::class, 'storeProject'])->name('admin.project.store');
    Route::patch('/projects/{project}',      [AdminController::class, 'updateProject'])->name('admin.project.update');
    Route::delete('/projects/{project}',     [AdminController::class, 'destroyProject'])->name('admin.project.destroy');
});
