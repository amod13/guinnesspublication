<?php

namespace App\Modules\EmployeeManagement\Providers;

use App\Modules\EmployeeManagement\Repositories\Implementations\BankDetailRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\ContactInfoRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\DepartmentRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\DesignationRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\EducationRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\EmployeeDetailRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\EmployeeInfoRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\EmployeeMasterDataRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\OfficialDocumentRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\SearchRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\SubDepartmentRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\SystemAccessRepository;
use App\Modules\EmployeeManagement\Repositories\Implementations\WorkExperienceRepository;
use App\Modules\EmployeeManagement\Repositories\Interfaces\BankDetailRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\ContactInfoRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\DesignationRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EducationRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeDetailRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeInfoRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeMasterDataRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\OfficialDocumentRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\SearchRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\SubDepartmentRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\SystemAccessRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Implementations\BankDetailService;
use App\Modules\EmployeeManagement\Services\Implementations\ContactService;
use App\Modules\EmployeeManagement\Services\Implementations\DepartmentService;
use App\Modules\EmployeeManagement\Services\Implementations\DesignationService;
use App\Modules\EmployeeManagement\Services\Implementations\EducationService;
use App\Modules\EmployeeManagement\Services\Implementations\EmpDetailService;
use App\Modules\EmployeeManagement\Services\Implementations\EmployeeInfoService;
use App\Modules\EmployeeManagement\Services\Implementations\EmployeeService;
use App\Modules\EmployeeManagement\Services\Implementations\FileUploadService;
use App\Modules\EmployeeManagement\Services\Implementations\OfficialDocumentService;
use App\Modules\EmployeeManagement\Services\Implementations\SubDepartmentService;
use App\Modules\EmployeeManagement\Services\Implementations\SystemAccessService;
use App\Modules\EmployeeManagement\Services\Implementations\WorkExperienceService;
use App\Modules\EmployeeManagement\Services\Interfaces\BankDetailServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\ContactSerivceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DepartmentServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DesignationServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EducationServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmpDetailServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeInfoServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\FileUploadServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\OfficialDocumentServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\SubDepartmentServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\SystemAccessServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\WorkExperienceServiceInterface;
use Illuminate\Support\ServiceProvider;

class EmployeeManagementServiceProvider extends ServiceProvider
{
    public function register()
    {
        // repositories binding
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(DesignationRepositoryInterface::class, DesignationRepository::class);
        $this->app->bind(EmployeeInfoRepositoryInterface::class, EmployeeInfoRepository::class);
        $this->app->bind(ContactInfoRepositoryInterface::class, ContactInfoRepository::class);
        $this->app->bind(EmployeeDetailRepositoryInterface::class, EmployeeDetailRepository::class);
        $this->app->bind(EducationRepositoryInterface::class, EducationRepository::class);
        $this->app->bind(SubDepartmentRepositoryInterface::class, SubDepartmentRepository::class);
        $this->app->bind(WorkExperienceRepositoryInterface::class, WorkExperienceRepository::class);
        $this->app->bind(OfficialDocumentRepositoryInterface::class, OfficialDocumentRepository::class);
        $this->app->bind(SystemAccessRepositoryInterface::class, SystemAccessRepository::class);
        $this->app->bind(BankDetailRepositoryInterface::class, BankDetailRepository::class);
        $this->app->bind(SearchRepositoryInterface::class, SearchRepository::class);
        $this->app->bind(EmployeeMasterDataRepositoryInterface::class, EmployeeMasterDataRepository::class);

        // services binding
        $this->app->bind(DepartmentServiceInterface::class, DepartmentService::class);
        $this->app->bind(SubDepartmentServiceInterface::class, SubDepartmentService::class);
        $this->app->bind(DesignationServiceInterface::class, DesignationService::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->bind(EducationServiceInterface::class, EducationService::class);
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
        $this->app->bind(WorkExperienceServiceInterface::class, WorkExperienceService::class);
        $this->app->bind(OfficialDocumentServiceInterface::class, OfficialDocumentService::class);
        $this->app->bind(SystemAccessServiceInterface::class, SystemAccessService::class);
        $this->app->bind(BankDetailServiceInterface::class, BankDetailService::class);
        $this->app->bind(EmployeeInfoServiceInterface::class, EmployeeInfoService::class);
        $this->app->bind(ContactSerivceInterface::class, ContactService::class);
        $this->app->bind(EmpDetailServiceInterface::class, EmpDetailService::class);
        $this->mergeConfigFrom(__DIR__ . '/../Config/employeemanagement.php', 'employeemanagement');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'employeemanagement');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('modules/employeemanagement'),
        ], 'employeemanagement-assets');
    }
}
