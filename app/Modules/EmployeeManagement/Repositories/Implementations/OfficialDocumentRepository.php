<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\OfficialDocument;
use App\Modules\EmployeeManagement\Repositories\Interfaces\OfficialDocumentRepositoryInterface;

class OfficialDocumentRepository extends BaseRepository implements OfficialDocumentRepositoryInterface
{
    public function __construct(OfficialDocument $model) {
        parent::__construct($model);
    }
}
