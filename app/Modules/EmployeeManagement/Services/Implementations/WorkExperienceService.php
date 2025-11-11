<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Constant\Uploads;
use App\Modules\EmployeeManagement\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\FileUploadServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\WorkExperienceServiceInterface;

class WorkExperienceService extends BaseService implements WorkExperienceServiceInterface
{
    protected $repository, $fileService;
    public function __construct(WorkExperienceRepositoryInterface $repository, FileUploadServiceInterface $fileService)
    {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    public function createWorkDetail($data, $employeeId)
    {
        $data['employee_id'] = $employeeId;

        $fileName = $this->fileService->uploadFile(
            file: $data['experience_letter'],
            path: $employeeId . '/' . Uploads::WORK_EXPERIENCE,
            disk: 'public'
        );

        $data['experience_letter'] = $fileName;
        return $this->createRecord($data);
    }


    public function deleteworkDetail($id, $employeeId)
    {
        $record = $this->repository->editRecordByIdAndEmployeeId($id, $employeeId);

        if (!$record) {
            return false; // record not found
        }

        $fileName = $record->experience_letter;
        $path = $employeeId . '/' . Uploads::WORK_EXPERIENCE;

        if ($fileName) {
            $this->fileService->deleteFile($path, $fileName, 'public');
        }

        $deleted = $this->repository->deleteRecordByIdAndEmployeeId($id, $employeeId);

        return $deleted; // true if deletion succeeded, false otherwise
    }


    public function updateWorkDetail($data, $id, $employeeId)
    {
        $data['id'] = $id;
        $data['employee_id'] = $employeeId;

        $record = $this->repository->editRecordByIdAndEmployeeId($id, $employeeId);
        // Case 1: No new file uploaded
        if (empty($data['experience_letter'])) {
            $data['experience_letter'] = $record->experience_letter; // retain old file name
        } else {
            // Case 2: File uploaded — delete old, upload new
            $oldFileName = $record->experience_letter;
            $path = $employeeId . '/' . Uploads::WORK_EXPERIENCE;

            if ($oldFileName) {
                $this->fileService->deleteFile($path, $oldFileName, 'public');
            }

            $file = $data['experience_letter'];
            if ($file) {
                // get the stored filename and assign it to DTO
                $storedName = $this->fileService->uploadFile($file, $path, 'public');
                $data['experience_letter'] = $storedName;
            }
        }
        return $this->repository->updateRecordByIdAndEmployeeId($data, $id, $employeeId);
    }
}
