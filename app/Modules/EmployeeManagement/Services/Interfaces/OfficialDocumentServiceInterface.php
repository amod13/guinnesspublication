<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface OfficialDocumentServiceInterface extends BaseServiceInterface
{
    public function storeOfficalDocument($data, $employeeId);


    public function updateDocumentDetail($data, $id, $employeeId);
}
