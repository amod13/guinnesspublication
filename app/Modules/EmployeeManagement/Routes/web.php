<?php

use Illuminate\Support\Facades\Route;
use App\Modules\EmployeeManagement\Controllers\EmployeeController;
use App\Modules\EmployeeManagement\Controllers\DepartmentController;
use App\Modules\EmployeeManagement\Controllers\DesignationController;
use App\Modules\EmployeeManagement\Controllers\Employee\EmpBankDetailController;
use App\Modules\EmployeeManagement\Controllers\SubDepartmentController;
use App\Modules\EmployeeManagement\Controllers\Employee\EmpBasicDetailController;
use App\Modules\EmployeeManagement\Controllers\Employee\EmpDocumentController;
use App\Modules\EmployeeManagement\Controllers\Employee\EmpEduDetailController;
use App\Modules\EmployeeManagement\Controllers\Employee\EmpSystemAccessController;
use App\Modules\EmployeeManagement\Controllers\Employee\EmpWorkExpController;

Route::middleware(['web'])->group(function () {

    Route::prefix('admin/deparment')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('department.index');
        Route::get('/create', 'create')->name('department.create');
        Route::post('/store', 'store')->name('department.store');
        Route::get('/edit/{id}', 'edit')->name('department.edit');
        Route::put('/update/{id}', 'update')->name('department.update');
        Route::delete('/delete/{id}', 'delete')->name('department.delete');
    });


    Route::prefix('admin/subDepartment')->controller(SubDepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('subdepartment.index');
        Route::get('/create', 'create')->name('subdepartment.create');
        Route::post('/store', 'store')->name('subdepartment.store');
        Route::get('/edit/{id}', 'edit')->name('subdepartment.edit');
        Route::put('/update/{id}', 'update')->name('subdepartment.update');
        Route::delete('/delete/{id}', 'delete')->name('subdepartment.delete');

        Route::get('/getSubDepartment/{deptId}', 'getSubdeptIdAndName')->name('subdepartment.getIdAndName');

        //json return
        Route::post('/getSubDept', 'getSubDeptJson')->name('subdepartment.getIdNameJson');

    });


    Route::prefix('admin/designation')->controller(DesignationController::class)->group(function () {
        Route::get('/', 'index')->name('designation.index');
        Route::get('/create', 'create')->name('designation.create');
        Route::post('/store', 'store')->name('designation.store');
        Route::get('/edit/{id}', 'edit')->name('designation.edit');
        Route::put('/update/{id}', 'update')->name('designation.update');
        Route::delete('/delete/{id}', 'delete')->name('designation.delete');
    });



    // personal detail
    Route::prefix('admin/employee/')->controller(EmpBasicDetailController::class)->group(function () {

        Route::get('/create/basic/{employeeId?}', 'personalDetailForm')->name('employee.create.basic');

        Route::post('/store-basic', 'storeBasicInfo')->name('employee.store.basic');

        Route::put('/update-basic/{employeeId}', 'updateBasicInfo')->name('employee.edit.basic');
    });


    // Education Detail
    Route::prefix('admin/employee/')->controller(EmpEduDetailController::class)->group(function () {

        Route::get('create/education/{employeeId}', 'educationFrom')->name('employee.create.education');

        Route::post('/store-education/{employeeId}', 'storeEducationDetail')->name('employee.store.education');

        Route::get('/{employeeId}/education/{eduId}', 'editEducationDetail')->name('employee.edit.education');

        Route::delete('/{employeeId}/education-delete/{eduId}/', 'deleteEducationDetail')->name('employee.delete.education');

        Route::put('/{employeeId}/education/{eduId}/', 'updateEducationDetail')->name('employee.update.education');
    });

    // Work Experience Detail
    Route::prefix('admin/employee/')->controller(EmpWorkExpController::class)->group(function () {

        Route::get('create/work-experience/{employeeId}', 'workExperienceForm')->name('employee.create.work');

        Route::post('/store-work/{employeeId}', 'storeWorkDetail')->name('employee.store.work');

        Route::delete('/{employeeId}/work-delete/{id}', 'deleteworkDetail')->name('employee.delete.work');

        Route::get('/{employeeId}/work/{id}/', 'editworkDetail')->name('employee.edit.work');

        Route::put('/{employeeId}/work-update/{id}', 'updateworkDetail')->name('employee.update.work');
    });

    // Document Detail
    Route::prefix('admin/employee/')->controller(EmpDocumentController::class)->group(function () {
        Route::get('create/document/{employeeId}', 'documentDetailForm')->name('employee.create.document');

        Route::post('/store-document/{employeeId}', 'storeDocumentDetail')->name('employee.store.document');

        Route::put('/{employeeId}/official-document/{id}', 'updateDocumentDetail')->name('employee.update.document');
    });

    // Bank Detail
    Route::prefix('admin/employee/')->controller(EmpBankDetailController::class)->group(function () {

        Route::get('create/bank-details/{employeeId}', 'bankDetailFrom')->name('employee.create.bank');

        Route::post('/store-bank-detail/{employeeId}', 'storeBankDetail')->name('employee.store.bank');

        Route::get('/{employeeId}/bank-detail/{id}', 'editBankDetail')->name('employee.edit.bank');

        Route::put('/update-bank-detail/{id}/{employeeId}', 'updateBankDetail')->name('employee.update.bank');

        Route::delete('/{employeeId}/delete-bank-detail/{id}/', 'deleteBankDetail')->name('employee.delete.bank');
    });


    // System Access
    Route::prefix('admin/employee')->controller(EmpSystemAccessController::class)->group(function () {
        Route::get('create/system-access/{employeeId}', 'systemAccessFrom')->name('employee.create.system.access');

        Route::post('/store-system-access/{employeeId}', 'storeSystemAccessDetail')->name('employee.store.system.access');

        Route::put('/{employeeId}/update-system-access/{id}', 'updateSystemAccessDetail')->name('employee.update.system.access');
    });


    Route::prefix('admin/employee')->controller(EmployeeController::class)->group(function () {
        Route::get('/', 'index')->name('employee.index');
        Route::get('/{id}/detail', 'employeeDetail')->name('employee.detail');
    });

});


