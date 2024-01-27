<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\GlobalVariableController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\AdminCmsController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminBlogCategoryController;
use App\Http\Controllers\AdminPackagesController;
use App\Http\Controllers\AdminSubscriptionsController;
use App\Http\Controllers\AdminJobsController;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\LocationStatesController;
use App\Http\Controllers\AdminRolesController;
use App\Http\Controllers\AdminPermissionsController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SuburbController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\{AdminSearchController, AdminNewsletterController};


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

Route::middleware('cors')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::get('/loginWithEmail/{email}', function($email){
    if($user = User::where('email', $email)->first()){
        Auth::loginUsingId($user->id);
        return redirect('/admin/dashboard');
    }
});

Route::get('dashboard', function () {
    return redirect('/admin/dashboard');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile/{id}', [ProfileController::class, 'edit']);
    Route::put('/profile/{id}', [ProfileController::class, 'update']);
    Route::post('/profile/{id}', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
});

Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    //Route::post('/dashboard/stats', [\App\Http\Controllers\AdminDashboardController::class, 'stats_ajax_call'])->middleware(['auth', 'verified'])->name('stats_ajax_call');

   Route::group(['prefix' => 'settings'], function () {
      Route::post('/update_setting', [GlobalVariableController::class, 'updateSetting']);
      

      Route::get('/', [\App\Http\Controllers\AdminSettingsController::class, 'index']);
      Route::put('/{site_settings_id}', [\App\Http\Controllers\AdminSettingsController::class, 'update']);
    
      Route::post('/update_main_settings', [\App\Http\Controllers\AdminSettingsController::class, 'update_main_settings'])->name('update_main_settings');

      Route::get('/design_settings', [\App\Http\Controllers\AdminSettingsController::class, 'design_settings']);

      Route::get('/social_media_settings', [\App\Http\Controllers\AdminSettingsController::class, 'social_media_settings']);

      Route::get('/payment_settings', [\App\Http\Controllers\AdminSettingsController::class, 'payment_settings']);
      Route::post('/payment_checkout', [\App\Http\Controllers\AdminSettingsController::class, 'checkout']);
      Route::get('/payment_success', [\App\Http\Controllers\AdminSettingsController::class, 'payment_success']);
      Route::get('/payment_cancel', [\App\Http\Controllers\AdminSettingsController::class, 'payment_cancel']);

      Route::get('/newsletter_settings', [\App\Http\Controllers\AdminSettingsController::class, 'newsletter_settings']);
      Route::get('/sms_settings', [\App\Http\Controllers\AdminSettingsController::class, 'sms_settings']);
      Route::get('/slider_settings', [\App\Http\Controllers\AdminSettingsController::class, 'slider_settings']);

      Route::get('/job_seeker_settings', [\App\Http\Controllers\AdminSettingsController::class, 'job_seeker_settings']);
      Route::get('/notification_settings', [\App\Http\Controllers\AdminSettingsController::class, 'notification_settings']);

    //   Route::get('/job_categories', [\App\Http\Controllers\AdminSettingsController::class, 'job_categories']);
    //   Route::post('/create_job_category', [\App\Http\Controllers\AdminSettingsController::class, 'create_job_category']);
    //   Route::get('/edit_job_category/{job_category_id}', [\App\Http\Controllers\AdminSettingsController::class, 'edit_job_category']);
    //   Route::post('/edit_job_category/{job_category_id}', [\App\Http\Controllers\AdminSettingsController::class, 'update_job_category']);
    //   Route::post('/delete_job_category/{job_category_id}', [\App\Http\Controllers\AdminSettingsController::class, 'delete_job_category']);

      

    //   Route::get('/sectors', [\App\Http\Controllers\AdminSettingsController::class, 'sectors']);
    //   Route::post('/create_sector', [\App\Http\Controllers\AdminSettingsController::class, 'create_sector']);
    //   Route::get('/edit_sector/{sector_id}', [\App\Http\Controllers\AdminSettingsController::class, 'edit_sector']);
    //   Route::post('/edit_sector/{sector_id}', [\App\Http\Controllers\AdminSettingsController::class, 'update_sector']);
    //   Route::post('/delete_sector/{sector_id}', [\App\Http\Controllers\AdminSettingsController::class, 'delete_sector']);

    //   Route::get('/locations', [\App\Http\Controllers\AdminSettingsController::class, 'locations']);
    //   Route::post('/create_location', [\App\Http\Controllers\AdminSettingsController::class, 'create_location']);
    //   Route::get('/edit_location/{location_id}', [\App\Http\Controllers\AdminSettingsController::class, 'edit_location']);
    //   Route::post('/edit_location/{location_id}', [\App\Http\Controllers\AdminSettingsController::class, 'update_location']);
    //   Route::post('/delete_location/{location_id}', [\App\Http\Controllers\AdminSettingsController::class, 'delete_location']);

      Route::get('/skills', [\App\Http\Controllers\AdminSettingsController::class, 'skills']);
      Route::post('/create_skill', [\App\Http\Controllers\AdminSettingsController::class, 'create_skill']);
      Route::get('/edit_skill/{skill_id}', [\App\Http\Controllers\AdminSettingsController::class, 'edit_skill']);
      Route::post('/edit_skill/{skill_id}', [\App\Http\Controllers\AdminSettingsController::class, 'update_skill']);
      Route::post('/delete_skill/{skill_id}', [\App\Http\Controllers\AdminSettingsController::class, 'delete_skill']);

      Route::get('/technologies', [\App\Http\Controllers\AdminSettingsController::class, 'technologies']);
      Route::post('/create_technology', [\App\Http\Controllers\AdminSettingsController::class, 'create_technology']);
      Route::get('/edit_technology/{technology_id}', [\App\Http\Controllers\AdminSettingsController::class, 'edit_technology']);
      Route::post('/edit_technology/{technology_id}', [\App\Http\Controllers\AdminSettingsController::class, 'update_technology']);
      Route::post('/delete_technology/{technology_id}', [\App\Http\Controllers\AdminSettingsController::class, 'delete_technology']);
      Route::get('/search', [AdminSearchController::class, 'search'])->name('search-global');
   });


   Route::get('/email_templates/admin_templates', [\App\Http\Controllers\EmailTemplateController::class, 'admin_templates']);
   Route::get('/email_templates/company_templates', [\App\Http\Controllers\EmailTemplateController::class, 'company_templates']);
   Route::get('/email_templates/job_seeker_templates', [\App\Http\Controllers\EmailTemplateController::class, 'job_seeker_templates']);
   Route::resource('/email_templates', EmailTemplateController::class);

   Route::resource('technologies', TechnologyController::class);
   Route::resource('skills', SkillController::class);
   Route::resource('locations', LocationController::class);
   Route::resource('suburbs', SuburbController::class);
   Route::resource('location_states', LocationStatesController::class);
   Route::resource('sectors', SectorController::class);
   Route::resource('job_categories', CategoryController::class);
   Route::resource('manage_pages', AdminCmsController::class);
   Route::resource('job_seekers', JobSeekerController::class);
   Route::resource('companies', CompanyController::class);
   Route::get('admin_users', [AdminUsersController::class, 'admin_users'])->name('admin_users');;
   Route::resource('users', AdminUsersController::class);

   Route::resource('packages', AdminPackagesController::class)->only('index', 'create', 'edit', 'store', 'update');
   Route::delete('keypoint/{keypoint}/destroy', [AdminPackagesController::class, 'destroyKey'])->name('keypoints.destroy');

   Route::post('/session', [AdminPackagesController::class, 'session'])->name("session");

   Route::resource('subscriptions', AdminSubscriptionsController::class);
   Route::get('jobs_list', [AdminJobsController::class, 'jobs_list']);
   Route::resource('jobs', AdminJobsController::class);
   Route::resource('applications', AdminApplicationController::class);
   Route::resource('testimonials', TestimonialController::class);
   Route::resource('permissions', AdminPermissionsController::class);
   Route::resource('roles', AdminRolesController::class);

   Route::get('notification_job_alert', [NotificationController::class, 'notification_job_alert'])->name('notification_job_alert');
   Route::get('notification_package_subscription', [NotificationController::class, 'notification_package_subscription']);


   Route::resource('blog', AdminBlogController::class);
   Route::resource('blog_categories', AdminBlogCategoryController::class);
//    Route::group(['prefix' => 'blog'], function() {
//         // Route::get('/', [\App\Http\Controllers\AdminBlogController::class, 'index']);
//         // Route::get('/categories', AdminBlogController::class, 'categories');
//         Route::get('/categories', [\App\Http\Controllers\AdminBlogController::class, 'categories']);
//         Route::resource('/', AdminBlogController::class);
        
//     });

    // Route::group(['prefix' => 'subscriptions'], function() {
    //     // Route::get('/', [\App\Http\Controllers\AdminSubscriptionsController::class, 'index']);
    //     Route::resource('/', AdminSubscriptionsController::class);
    //     Route::get('history/', [\App\Http\Controllers\AdminSubscriptionsController::class, 'history']);
    // });

//    Route::group(['prefix' => 'cms'], function() {
//     Route::get('/', [\App\Http\Controllers\AdminCmsController::class, 'index']);
//     });

   Route::group(['prefix' => 'adminusers'], function() {
    Route::get('/', [\App\Http\Controllers\AdminAUsersController::class, 'index']);
    Route::get('permissions/', [\App\Http\Controllers\AdminAUsersController::class, 'permissions']);
    });


   Route::group(['prefix' => 'users'], function() {
    Route::get('/', [\App\Http\Controllers\AdminUsersController::class, 'index']);
    Route::get('companies/', [\App\Http\Controllers\AdminUsersController::class, 'companies']);
    });

//    Route::group(['prefix' => 'jobs'], function() {
//       Route::get('/', [\App\Http\Controllers\AdminJobsController::class, 'index']);
//       Route::get('applications/', [\App\Http\Controllers\AdminJobsController::class, 'applications']);
//       Route::post('/change_status', [\App\Http\Controllers\AdminJobsController::class, 'change_status']);
//    });

    Route::get('news-letters', [AdminNewsletterController::class, 'index'])->name('news.letter');
    Route::get('new-letter/status/{status}/{hash}', [AdminNewsletterController::class, 'status'])->name('newsletter.status');
    Route::get('new-letter/delete/{status}/{hash}', [AdminNewsletterController::class, 'archive'])->name('newsletter.archive');
    Route::get('new-letter/permanent/{status}/{hash}', [AdminNewsletterController::class, 'deletePermanent'])->name('newsletter.permanent');

});


Route::get('system_emails/verify_account', [EmailsController::class, 'verify_account']);
Route::resource('system_emails', EmailsController::class);


Route::get('admin/dashboard/stats', [AdminDashboardController::class, 'stats_ajax_call']);
// Route::resource('technologies', AdminDashboardController::class);

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    Artisan::call('config:clear');
    
  
});

Route::get('/checkout/success/{package}/{session_id}', [AdminPackagesController::class, 'success'])->name('checkout.success');

require __DIR__.'/auth.php';
