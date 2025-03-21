<?php

use App\Livewire\Auth\Login;
use App\Livewire\LeaveRequest\LeaveRequestDetail;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Role\RoleForm;
use App\Livewire\Site\SiteForm;
use App\Livewire\TestComponent;
use App\Livewire\Site\SiteIndex;
use App\Livewire\Site\SiteDetail;
use App\Livewire\Profile\ProfileForm;
use App\Livewire\Project\ProjectForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Machine\MachineIndex;
use App\Livewire\Profile\ProfileIndex;
use App\Livewire\Project\ProjectIndex;
use App\Livewire\Employee\EmployeeForm;
use App\Livewire\Employee\EmployeePermission;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Employee\EmployeeIndex;
use App\Livewire\Position\PositionIndex;
use App\Livewire\Employee\EmployeeDetail;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Attendance\AttendanceForm;
use App\Livewire\Attendance\AttendanceIndex;
use App\Livewire\Attendance\AttendanceAll;
use App\Livewire\DailyReport\DailyReportAll;
use App\Livewire\Department\DepartmentIndex;
use App\Http\Controllers\SendEmailController;
use App\Livewire\Attendance\AttendanceDetail;
use App\Livewire\DailyReport\DailyReportForm;
use App\Livewire\DailyReport\DailyReportTeam;
use App\Livewire\Department\DepartmentDetail;
use App\Livewire\DailyReport\DailyReportIndex;
use App\Http\Controllers\ImageUploadController;
use App\Livewire\DailyReport\DailyReportDetail;
use App\Livewire\LeaveRequest\LeaveRequestForm;
use App\Livewire\LeaveRequest\LeaveRequestTeam;
use App\Livewire\AbsentRequest\AbsentRequestAll;
use App\Livewire\LeaveRequest\LeaveRequestIndex;
use App\Livewire\AbsentRequest\AbsentRequestForm;
use App\Livewire\AbsentRequest\AbsentRequestTeam;
use App\Livewire\AbsentRequest\AbsentRequestIndex;
use App\Livewire\AbsentRequest\AbsentRequestDetail;
use App\Livewire\ImportMasterData\ImportMasterDataIndex;
use App\Livewire\EmailTemplateManager\EmailTemplateManagerForm;
use App\Livewire\EmailTemplateManager\EmailTemplateManagerIndex;
use App\Livewire\LeaveRequest\LeaveRequestAll;
use App\Livewire\Announcement\AnnouncementIndex;
use App\Livewire\Announcement\AnnouncementForm;
use App\Livewire\Announcement\AnnouncementDetail;
use App\Livewire\Categoryinventory\CategoryinventoryIndex;
use App\Livewire\Categoryinventory\CategoryinventoryForm;
use App\Livewire\Inventory\InventoryIndex;
use App\Livewire\Inventory\InventoryDetail;
use App\Livewire\Inventory\InventoryForm;
use App\Livewire\Inventory\InventoryShow;
use App\Livewire\StatusInventory\StatusInventoryIndex;
use App\Livewire\StatusInventory\StatusInventoryForm;
use App\Livewire\StatusInventory\StatusInventoryShow;
use App\Livewire\StatusInventory\StatusInventoryItem;
use App\Livewire\EmployeeInventory\EmployeeInventoryIndex;
use App\Livewire\EmployeeInventory\EmployeeInventoryForm;
use App\Livewire\EmployeeInventory\EmployeeInventoryShow;
use App\Livewire\EmployeeInventory\EmployeeInventoryItem;
use App\Livewire\ItemRequest\ItemrequestIndex;
use App\Livewire\ItemRequest\ItemrequestForm;
use App\Livewire\ItemRequest\ItemrequestDetail;
use App\Livewire\Notification\NotificationIndex;
use App\Livewire\Project\ProjectTeam;
use App\Livewire\Report\ReportAttendance;
use App\Livewire\Client\ClientIndex;
use App\Livewire\Client\ClientForm;
use App\Livewire\Categoryproject\CategoryProjectIndex;
use App\Livewire\Categoryproject\CategoryProjectForm;
use App\Http\Controllers\SocialiteController;

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

Route::get('/test-component', TestComponent::class)->name('test-component');
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);
Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::post('upload-image', [ImageUploadController::class, 'upload']);
    Route::get('send-mail', [SendEmailController::class, 'newUser'])->name('send-mail');

    Route::get('/', DashboardIndex::class)->name('dashboard.index')->middleware('can:view:dashboard');
    Route::get('dashboard', DashboardIndex::class)->name('dashboard.index')->middleware('can:view:dashboard');
    Route::get('import-master-data', ImportMasterDataIndex::class)->name('import.index')->middleware('can:view:import_master_data');

    Route::get('machine', MachineIndex::class)->name('machine.index')->middleware('can:view:machine');

    Route::group(['prefix' => 'site'], function () {
        Route::get('/', SiteIndex::class)->name('site.index')->middleware('can:view:site');
        Route::get('create', SiteForm::class)->name('site.create')->middleware('can:create:site');
        Route::get('edit/{uid}', SiteForm::class)->name('site.edit')->middleware('can:update:site');
        Route::get('detail/{uid}', SiteDetail::class)->name('site.detail')->middleware('can:view:site');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::get('/', DepartmentIndex::class)->name('department.index')->middleware('can:view:department');
        Route::get('detail/{id}', DepartmentDetail::class)->name('department.detail')->middleware('can:view:department');
    });

    Route::group(['prefix' => 'position'], function () {
        Route::get('/', PositionIndex::class)->name('position.index')->middleware('can:view:position');
        Route::get('detail/{id}', DepartmentDetail::class)->name('position.detail')->middleware('can:view:position');
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('/', ProjectIndex::class)->name('project.index')->middleware('can:view:project');
        Route::get('team', ProjectTeam::class)->name('project-team.index')->middleware('can:view:project');
        Route::get('detail/{id}', ProjectDetail::class)->name('project.detail')->middleware('can:view:project');
        Route::get('create', ProjectForm::class)->name('project.create')->middleware('can:create:project');
        Route::get('edit/{id}', ProjectForm::class)->name('project.edit')->middleware('can:update:project');
    });

    // Menambahkan route untuk Client
    Route::group(['prefix' => 'client'], function () {
        Route::get('/', ClientIndex::class)->name('client.index')->middleware('can:view:client');
        Route::get('create', ClientForm::class)->name('client.create')->middleware('can:create:client');
        Route::get('edit/{id}', ClientForm::class)->name('client.edit')->middleware('can:update:client');
    });

    // Menambahkan route untuk Category Project
    Route::group(['prefix' => 'category-project'], function () {
        Route::get('/', CategoryProjectIndex::class)->name('category-project.index')->middleware('can:view:category-project');
        Route::get('create', CategoryProjectForm::class)->name('category-project.create')->middleware('can:create:category-project');
        Route::get('edit/{id}', CategoryProjectForm::class)->name('category-project.edit')->middleware('can:update:category-project');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', RoleIndex::class)->name('role.index')->middleware('can:view:role');
        Route::get('create', RoleForm::class)->name('role.create')->middleware('can:create:role');
        Route::get('edit/{id}', RoleForm::class)->name('role.edit')->middleware('can:update:role');
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', EmployeeIndex::class)->name('employee.index')->middleware('can:view:employee');
        Route::get('detail/{id}', EmployeeDetail::class)->name('employee.detail')->middleware('can:view:employee');
        Route::get('create', EmployeeForm::class)->name('employee.create')->middleware('can:create:employee');
        Route::get('edit/{id}', EmployeeForm::class)->name('employee.edit')->middleware('can:update:employee');
        Route::get('permission/{id}', EmployeePermission::class)->name('employee.permission')->middleware('can:permission:employee');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', ProfileIndex::class)->name('profile.index')->middleware('can:view:profile');
        Route::get('edit', ProfileForm::class)->name('profile.edit')->middleware('can:update:profile');
        Route::get('edit/{id}', ProfileForm::class)->name('profile.edit.by.admin')->middleware(['can:update:profile', 'role:Administrator']);
    });

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/', AttendanceIndex::class)->name('attendance.index')->middleware(['can:view:attendance']);
        // Route::get('detail/{id}', AttendanceDetail::class)->name('attendance.detail');
        // Route::get('create', AttendanceForm::class)->name('attendance.create');
        // Route::get('edit/{id}', AttendanceForm::class)->name('attendance.edit');
    });

    Route::get('/daily-report-all', DailyReportAll::class)->name('daily-report.all')->middleware('can:view:daily-report-all');
    Route::get('/attendance-all', AttendanceAll::class)->name('attendance.all')->middleware('can:view:attendance-all');
    Route::get('/absent-request-all', AbsentRequestAll::class)->name('absent-request.all')->middleware('can:view:absent-request-all');
    Route::get('/leave-request-all', LeaveRequestAll::class)->name('leave-request.all')->middleware('can:view:leave-request-all');

    // Route::get('site', 'path.to.view')->name('site.index');
    // Route::get('department', 'path.to.view')->name('department.index');
    // Route::get('role', 'path.to.view')->name('role.index');
    // Route::get('user', 'path.to.view')->name('user.index');
    // Route::get('employee', 'path.to.view')->name('employee.index');
    // Route::get('attendance', 'path.to.view')->name('attendance.index');
    // Route::get('attendance-temporary', 'path.to.view')->name('attendance-temporary.index');

    Route::group(['prefix' => 'daily-report'], function () {
        Route::get('/', DailyReportIndex::class)->name('daily-report.index')->middleware('can:view:daily-report');
        Route::get('team', DailyReportTeam::class)->name('team-daily-report.index')->middleware('can:view:daily-report');
        Route::get('create', DailyReportForm::class)->name('daily-report.create')->middleware('can:create:daily-report');
        Route::get('edit/{id}', DailyReportForm::class)->name('daily-report.edit')->middleware('can:update:daily-report');
        Route::get('detail/{id}', DailyReportDetail::class)->name('daily-report.detail')->middleware('can:view:daily-report');
    });

    Route::group(['prefix' => 'absent-request'], function () {
        Route::get('/', AbsentRequestIndex::class)->name('absent-request.index')->middleware('can:view:absent-request');
        Route::get('team', AbsentRequestTeam::class)->name('team-absent-request.index')->middleware('can:view:absent-request');
        Route::get('create', AbsentRequestForm::class)->name('absent-request.create')->middleware('can:create:absent-request');
        Route::get('edit/{id}', AbsentRequestForm::class)->name('absent-request.edit')->middleware('can:update:absent-request');
        Route::get('detail/{id}', AbsentRequestDetail::class)->name('absent-request.detail')->middleware('can:view:absent-request');
    });

    Route::group(['prefix' => 'leave-request'], function () {
        Route::get('/', LeaveRequestIndex::class)->name('leave-request.index')->middleware('can:view:leave-request');
        Route::get('team', LeaveRequestTeam::class)->name('team-leave-request.index')->middleware('can:view:leave-request');
        Route::get('create', LeaveRequestForm::class)->name('leave-request.create')->middleware('can:create:leave-request');
        Route::get('edit/{id}', LeaveRequestForm::class)->name('leave-request.edit')->middleware('can:update:leave-request');
        Route::get('detail/{id}', LeaveRequestDetail::class)->name('leave-request.detail')->middleware('can:view:leave-request');
    });

    Route::group(['prefix' => 'email-template'], function () {
        Route::get('/', EmailTemplateManagerIndex::class)->name('email-template.index');
        Route::get('create', EmailTemplateManagerForm::class)->name('email-template.create');
        Route::get('edit/{slug}', EmailTemplateManagerForm::class)->name('email-template.edit');
    });

    Route::group(['prefix' => 'announcement'], function () {
        Route::get('/', AnnouncementIndex::class)->name('announcement.index')->middleware('can:view:announcement');
        Route::get('detail/{id}', AnnouncementDetail::class)->name('announcement.detail')->middleware('can:view:announcement');
        Route::get('create', AnnouncementForm::class)->name('announcement.create')->middleware('can:create:announcement');
        Route::get('edit/{id}', AnnouncementForm::class)->name('announcement.edit')->middleware('can:update:announcement');
    });

    Route::group(['prefix' => 'category-inventory'], function () {
        Route::get('/', CategoryInventoryIndex::class)->name('category.index')->middleware('can:view:category-inventory');
        Route::get('create', CategoryInventoryForm::class)->name('category.create')->middleware('can:create:category-inventory');
        Route::get('edit/{id}', CategoryInventoryForm::class)->name('category.edit')->middleware('can:update:category-inventory');
    });

    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', InventoryIndex::class)->name('inventory.index')->middleware('can:view:inventory');
        Route::get('detail/{id}', InventoryDetail::class)->name('inventory.detail');
        Route::get('create', InventoryForm::class)->name('inventory.create')->middleware('can:create:inventory');
        Route::get('edit/{id}', InventoryForm::class)->name('inventory.edit')->middleware('can:update:inventory');
    });

    Route::group(['prefix' => 'status-inventory'], function () {
        Route::get('/', StatusInventoryIndex::class)->name('status-inventory.index')->middleware('can:view:status-inventory');
        Route::get('create', StatusInventoryForm::class)->name('status-inventory.create')->middleware('can:create:status-inventory');
        Route::get('edit/{id}', StatusInventoryForm::class)->name('status-inventory.edit')->middleware('can:update:status-inventory');
    });

    Route::group(['prefix' => 'employee-inventory'], function () {
        Route::get('/', EmployeeInventoryIndex::class)->name('employee-inventory.index')->middleware('can:view:employee-inventory');
        Route::get('create', EmployeeInventoryForm::class)->name('employee-inventory.create')->middleware('can:create:employee-inventory');
        Route::get('edit/{id}', EmployeeInventoryForm::class)->name('employee-inventory.edit')->middleware('can:update:employee-inventory');
    });

    Route::group(['prefix' => 'item-request'], function () {
        Route::get('/', ItemrequestIndex::class)->name('item-request.index')->middleware('can:view:item-request');
        Route::get('detail/{id}', ItemrequestDetail::class)->name('item-request.detail')->middleware('can:view:item-request');
        Route::get('create', ItemrequestForm::class)->name('item-request.create')->middleware('can:create:item-request');
        Route::get('edit/{id}', ItemrequestForm::class)->name('item-request.edit')->middleware('can:update:item-request');
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', NotificationIndex::class)->name('notification.index');
    });


    Route::get('/report-attendance', ReportAttendance::class)
        ->name('report.attendance')
        ->middleware('can:view:report-attendance');
});

Route::get('inv/{code}', InventoryShow::class)->name('inventory.show');
