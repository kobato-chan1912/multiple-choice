<?php

class Apps_Models_Packages extends Apps_Libs_DbConnection
{
    protected $tableName = "Packages";
    public function buildSelectBox ($name)
    {
        $query = $this->buildQueryParams([
            "select" => 'package_name',
            "where" => "created_by=:created_by",
            "params" => [
                ":created_by" => $name
            ]
        ])->select();
        return $query;
    }

    public function buildSelectBoxLimit ($name, $pack)
    {
        $query = $this->buildQueryParams([
            "select" => 'package_name',
            "where" => "created_by=:created_by AND id=:id",
            "params" => [
                ":created_by" => $name,
                ":id" => $pack
            ]
        ])->select();
        return $query;
    }



    public function getIDPack ($name){
        $query = $this->buildQueryParams([
            "select" => 'id',
            "where" => 'package_name=:name',
            "params" => [
                ":name" => $name,
            ]
        ])->select();
        return $query[0]["id"];
    }
}
