<?php


class Apps_Models_Status extends Apps_Libs_DbConnection
{
    protected $tableName = "Status";

    public function buildSelectBox()
    {
        $query = $this->buildQueryParams([
            "select" => 'status_name'
        ])->select();
        return $query;
    }

    public function getIDStatus($name)
    {
        $query = $this->buildQueryParams([
            "select" => 'id',
            "where" => 'status_name=:name',
            "params" => [
                ":name" => $name,
            ]
        ])->select();
        return $query;
    }
}
