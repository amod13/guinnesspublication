<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\DTOs\employee\EducationDTO;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EducationRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EducationServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\FileUploadServiceInterface;
use App\Constant\Uploads;

class EducationService extends BaseService implements EducationServiceInterface
{
    protected $repository, $fileService;
    public function __construct(EducationRepositoryInterface $repository, FileUploadServiceInterface $fileService)
    {
        parent::__construct($repository);
        $this->fileService = $fileService;
        $this->repository = $repository;
    }


    public function storeEducation($data, $employeeId)
    {
        $data['employee_id'] = $employeeId;

        $fileName = $this->fileService->uploadFile(
            file: $data['certificate'],
            path: $employeeId . '/' . Uploads::EDUCATION_FOLDER,
            disk: 'public',
        );

        $data['certificate'] = $fileName;

        return $this->createRecord($data);
    }

    public function deleteEducationDetail($id, $employeeId)
    {

        $record = $this->repository->editRecordByIdAndEmployeeId($id, $employeeId);
        if (!$record) {
            return false;
        }

        $fileName =  $record->certificate;

        $path = $employeeId . '/' . Uploads::EDUCATION_FOLDER;

        if ($fileName) {
            $this->fileService->deleteFile($path, $fileName, 'public');
        }

        return $this->repository->deleteRecordByIdAndEmployeeId($id, $employeeId);
    }

    public function updateEducationDetail($data, $id, $employeeId)
    {
        $dto = EducationDTO::fromData($data)->toArray();
        $record = $this->repository->editRecordByIdAndEmployeeId($id, $employeeId);

        $dto = array_merge($dto, [
            'id' => $id,
            'employee_id' => $employeeId
        ]);


        // Case 1: No new file uploaded
        if (empty($dto['certificate'])) {
            $dto['certificate'] = $record->certificate; // retain old file name
        } else {
            // Case 2: File uploaded — delete old, upload new
            $oldFileName = $record->certificate;
            $path = $employeeId . '/' . Uploads::EDUCATION_FOLDER;

            if ($oldFileName) {
                $this->fileService->deleteFile($path, $oldFileName, 'public');
            }

            $file = $dto['certificate'];
            if ($file) {
                // get the stored filename and assign it to DTO
                $storedName = $this->fileService->uploadFile($file, $path, 'public');
                $dto['certificate'] = $storedName;
            }
        }

        return $this->repository->updateRecordByIdAndEmployeeId($dto, $id, $employeeId);
    }
}
