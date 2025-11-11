<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getActiveRecord()
    {
        return $this->model->where("status", 1)->get();
    }

    public function createRecord($data)
    {
        return $this->model->create($data);
    }

    public function editRecord($id)
    {
        return $this->model->find($id);
    }

    public function updateRecord($id, array $data)
    {
        $record = $this->model->find($id);

        if (!$record) {
            return false;
        }

        $record->update($data);
        return $record;
    }

    public function deleteRecord($id)
    {
        $record = $this->model->find($id);

        if (!$record) {
            return false;
        }

        return $record->delete();
    }

    public function getPaginationWithSearch($perPage, $search, $searchFields = [])
    {
        $query = $this->model->query();

        if (!empty($search) && !empty($searchFields)) {
            $query->where(function ($q) use ($search, $searchFields) {
                foreach ($searchFields as $field) {
                    if (str_contains($field, '.')) {
                        // Relation-based search
                        [$relation, $column] = explode('.', $field);
                        $q->orWhereHas($relation, function ($subQuery) use ($column, $search) {
                            $subQuery->where($column, 'LIKE', "%{$search}%");
                        });
                    } else {
                        // Direct column search
                        $q->orWhere($field, 'LIKE', "%{$search}%");
                    }
                }
            });
        }
        $query->orderBy('display_order', 'desc');

        return $query->paginate($perPage);
    }

    public function getMaxOrder()
    {
        return $this->model->max('display_order');
    }


    // get the data of of table based on table id and employeeid
    public function editRecordByIdAndEmployeeId($id, $employeeId)
    {
        return $this->model::where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();
    }

    public function listRecordByEmployeeId($employeeId)
    {
        return $this->model::where('employee_id', $employeeId)->get();
    }

    public function deleteRecordByIdAndEmployeeId($id, $employeeId)
    {
        return $this->model::where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();
    }

    public function updateRecordByIdAndEmployeeId($data, $id, $employeeId)
    {
        return $this->model::where('id', $id)
            ->where('employee_id', $employeeId)
            ->update($data);
    }

    public function editRecordByEmployeeId($employeeId)
    {
        return $this->model::where('employee_id', $employeeId)
            ->first();
    }

}
