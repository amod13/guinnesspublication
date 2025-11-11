<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\DTOs\employee\ContactInfoDTO;
use App\Modules\EmployeeManagement\DTOs\employee\EmployeeDetailDTO;
use App\Modules\EmployeeManagement\DTOs\employee\EmployeeListDTO;
use App\Modules\EmployeeManagement\DTOs\employee\EmployeeMasterDataDTO;
use App\Modules\EmployeeManagement\DTOs\employee\PersonalInfoDTO;
use App\Modules\EmployeeManagement\Models\EmployeeInformation;
use App\Modules\EmployeeManagement\Repositories\Implementations\DummyRepository;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeMasterDataRepositoryInterface;
use App\Modules\EmployeeManagement\Repositories\Interfaces\SearchRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\ContactSerivceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmpDetailServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Support\Facades\DB;

class EmployeeService extends BaseService implements EmployeeServiceInterface
{
    protected $personalInfoService, $contactInfoService, $employeeDetailService, $searchRepo, $repository;

    public function __construct(
        DummyRepository $dummyRepository,
        EmployeeInfoService $personalInfoService,
        ContactSerivceInterface $contactInfoService,
        EmpDetailServiceInterface $employeeDetailService,
        SearchRepositoryInterface $searchRepo,
        EmployeeMasterDataRepositoryInterface $repository
    ) {
        parent::__construct($dummyRepository);

        $this->personalInfoService = $personalInfoService;
        $this->contactInfoService = $contactInfoService;
        $this->employeeDetailService = $employeeDetailService;
        $this->searchRepo = $searchRepo;
        $this->repository = $repository;
    }


    public function getEmployeeDetail($id)
    {
        $data = $this->repository->getEmployeeDetail($id);



        $dto = EmployeeMasterDataDTO::fromRawData($data);

        $structuredDto = $dto->toStructuredArray();

        return $structuredDto;
    }


    // basic detail crud
    public function storeBasicEmployeeDetail($data) // pass
    {
        $personalInfo =  PersonalInfoDTO::fromData($data)->toArray();
        $personalInfo['employee_code'] = $this->generateEmployeeCode();
        $personalInfo['display_order'] = $this->personalInfoService->getMaxOrder() + 1;
        $employee = $this->personalInfoService->createRecord($personalInfo);

        $dtoRecord = $this->prepareDTORecord($data, $employee->id);

        $this->contactInfoService->createRecord($dtoRecord['contactInfoDto']);

        $this->employeeDetailService->createRecord($dtoRecord['employeeDetailDto']);

        return $employee->id;
    }

    private function generateEmployeeCode(): string
    {
        $prefix = config('employeemanagement.prefix', 'EMP');
        $total = EmployeeInformation::count() + 1; // sequential number
        $date = date(config('employeemanagement.date_format', 'Ymd'));

        $code = $prefix . $total . $date;

        return $code;
    }

    public function updateBasicInfo($data, $employeeId)
    {
        $dtoRecord = $this->prepareDTORecord($data, $employeeId);
        $this->personalInfoService->updateRecord($employeeId, $dtoRecord['personalInfoDto']);

        $record = $this->contactInfoService->editRecordByEmployeeId($employeeId);
        $this->contactInfoService->updateRecord($record->id, $dtoRecord['contactInfoDto']);

        $record = $this->employeeDetailService->editRecordByEmployeeId($employeeId);
        $this->employeeDetailService->updateRecord($record->id, $dtoRecord['employeeDetailDto']);

        return $employeeId;
    }

    public function getBasicEmployeeDetail($employeeId)
    {
        $personalInfo = $this->personalInfoService->editRecord($employeeId);
        $data['personalInformation'] = PersonalInfoDTO::fromData($personalInfo)->toArray();

        $contactInfo =  $this->contactInfoService->editRecordByEmployeeId($employeeId);
        $data['contactInformation'] = ContactInfoDTO::fromData($contactInfo)->toArray();

        $employeeDetail = $this->employeeDetailService->editRecordByEmployeeId($employeeId);
        $data['employeeDetail'] = EmployeeDetailDTO::fromData($employeeDetail)->toArray();

        return $data;
    }

    // searching process
    public function searchEmployee($searchField, $perPage)
    {
        // dd($searchField);

   
        $data =  $this->searchRepo->getPaginatedEmployeeList($searchField, $perPage);
        // dd($data);
        return EmployeeListDTO::fromCollection($data);
    }



    public function checkEmployeeExist($employeeId)
    {
        return EmployeeInformation::find($employeeId) !== null;
    }

    // // getts array of [1 => true, 2 => false]
    public function getCompletedSteps($employeeId): array
    {
        return [
            0 => $this->exist([
                'employee_information',
                'emp_contact_information',
                'emp_employment_details'
            ], $employeeId),

            1 => $this->exist(['emp_educational_backgrounds'], $employeeId),

            2 => $this->exist(['emp_work_experiences'], $employeeId),

            3 => $this->exist(['emp_official_documents'], $employeeId),

            4 => $this->exist(['emp_salary_details'], $employeeId),

            5 => $this->exist(['emp_system_accesses'], $employeeId),

            // 1 =>true,
            // 2 => true,
            // 3 => true,
            // 4 => true,
            // 5 => true
        ];

        // return [ 0 => true, 1 => true, 2 => true, 3 => false, 4 => false, 5 => false ];
    }

    // protected $steps = [
    //     0 => 'Personal Info',
    //     1 => 'Education',
    //     2 => 'Work',
    //     3 => 'Document',
    //     4 => 'Bank',
    //     5 => 'System Access',
    // ];

    // public function getMaxAllowedStepIndex(array $completedSteps): int
    // {
    //     foreach ($completedSteps as $step => $completed) {
    //         if ($completed === false) {
    //             return $step; // first false = allowed step
    //         }
    //     }
    //     // if all true → allow the last step
    //     return max(array_keys($completedSteps));
    // }

    public function exist(array $tables, $employeeId): bool
    {
        foreach ($tables as $table) {
            if ($table === 'employee_information') {
                $exists = DB::table($table)->where('id', $employeeId)->exists();
            } else {
                $exists = DB::table($table)->where('employee_id', $employeeId)->exists();
            }

            if (!$exists) {
                return false;
            }
        }

        return true;
    }

    // private functions
    private function prepareDTORecord($data, $employeeId = null)
    {
        $data['employee_id'] = $employeeId;
        return [
            'personalInfoDto' => PersonalInfoDTO::fromData($data)->toArray(),
            'contactInfoDto' => ContactInfoDTO::fromData($data)->toArray(),
            'employeeDetailDto' => EmployeeDetailDTO::fromData($data)->toArray(),
        ];
    }
}
