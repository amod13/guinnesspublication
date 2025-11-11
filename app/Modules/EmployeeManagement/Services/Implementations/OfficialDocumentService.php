<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Constant\Uploads;
use App\Modules\EmployeeManagement\DTOs\employee\OfficialDocumentDTO;
use App\Modules\EmployeeManagement\Repositories\Interfaces\OfficialDocumentRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\OfficialDocumentServiceInterface;

class OfficialDocumentService extends BaseService implements OfficialDocumentServiceInterface
{
    protected $repository, $fileservice;
    public function __construct(OfficialDocumentRepositoryInterface $repository, FileUploadService $fileservice)
    {
        parent::__construct($repository);
        $this->fileservice = $fileservice;
    }



    public function storeOfficalDocument($data, $employeeId)
    {
        $dto = OfficialDocumentDTO::fromData($data)->toArray();

        $dto['employee_id'] = $employeeId;

        $path = $employeeId . '/' . Uploads::OFFICAL_DOCUMENT_FOLDER;

        $uploadedFileNames = [];

        foreach ($this->fileFields as $field) {
            if (isset($data[$field])) {
                $uploadedFileNames[$field] = $this->fileservice->uploadFile($data[$field], $path, 'public');
            } else {
                // If not uploaded file, either null or existing filename (string)
                $uploadedFileNames[$field] = $data[$field] ?? null;
            }
        }

        $recordData = array_merge(
            $uploadedFileNames,
            ['employee_id' => $employeeId]
        );
        return $this->createRecord($recordData);
    }

    protected $fileFields = [
        'resume_cv',
        'citizenship',
        'pan_card',
        'appointment_letter',
        'employee_contract',
        'photo'
    ];

    public function updateDocumentDetail($data, $id, $employeeId)
    {
        $dto = OfficialDocumentDTO::fromData($data)->toArray();
        $dataRecord = $this->editRecordByEmployeeId($employeeId);

        $dto['employee_id'] = $employeeId;

        $finalFileData = []; // To collect final file names (old or new)

        foreach ($this->fileFields as $field) {
            $path = $employeeId . '/' . Uploads::OFFICAL_DOCUMENT_FOLDER;

            if (empty($dto[$field])) // if user not submitted the file
            {
                $finalFileData[$field] = $dataRecord[$field]; // if the image for that field was not uploaded we
                //just simply save get the image name form query and prepare another query
            } else // if the user have uploaded image then we need to delete the old file and write new one
            {
                $this->fileservice->deleteFile($path, $dataRecord[$field], 'public');
                $finalFileData[$field] = $this->fileservice->uploadFile($data[$field], $path, 'public');
            }
        }

        // Merge file data into DTO for DB update
        $dto = array_merge($dto, $finalFileData);

        // Now update the record
        return $this->updateRecord($id, $dto);
    }
}
