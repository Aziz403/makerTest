<?php

namespace App\Services;
use Illuminate\Support\Facades\Schema;

class ModelInfo
{
    public $modelName;
    public $className;
    public $tableName;
    public $columns;
    public $columnConfigs;


    public function __construct($modelName)
    {
        $className              = 'App\\Models\\'.$modelName;
        $model                  = new $className();

        $this->modelName        = $modelName;
        $this->className        = $className;
        $this->tableName        = ($model)->getTable();
        $this->columns          = Schema::getColumnListing($this->tableName);
        $this->columnConfigs    = [];
    }

    public function setColumnConfig($column, $config)
    {
        $this->columnConfigs[$column] = $config;
    }
}