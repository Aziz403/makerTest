<?php

namespace App\Traits;
use File;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

trait ModelHelper
{
    use MigrationHelper;


    public function checkModel()
    {
        $model = $this->argument('name');
        $models = $this->loadModels();

        return in_array("App\\Models\\$model", $models);
    }
    
    public function createModel()
    {
        $model = $this->argument('name');

        // ask to create the model
        $ask = $this->ask("$model Model does not exist! Do you want to create this model?", 'Yes');
        if ($ask == "Yes") {
            $columns = $this->askModelColumns();
            $this->generateModelFile($model, $columns);
            $this->createMigration($model, $columns);
            if($this->option('with-factories')){
                $this->createFactories();// TODO: add the data
            }
            
            return [
                'name'      => $model,
                'columns'   => $columns
            ];
        }
        else {
            // die with info
        };
    }

    public function loadModel()
    {
        $model = $this->argument('name');
        $columns = [];

        $class      = 'App\\Models\\'.$model;
        $instance   = new $class();
        $table      = $instance->getTable();
        $cols       = Schema::getColumnListing($table);

        foreach ($cols as $col) {
            $type = Schema::getColumnType($table, $col);
            $nullable = in_array($col, $instance->getAttributes()) || in_array($col, $instance->getDates());
        
            $columns[$col] = [
                'type' => $type,
                'nullable' => $nullable,
            ];
        }

        return [
            'name'      => $model,
            'table'     => $table,
            'columns'   => $columns
        ];
    }

    private function generateModelFile($name, $columns, $uses = [])
    {

    }

    private function askModelColumns()
    {
        $columns = [];

        while (true) {
            // ask the column name
            $column = $this->ask("Enter the column name, (to stop type 'Stop')", "Yes");
            if ($column == "Stop") break;
            $columns[$column] = [];

            // ask the column type
            $type = $this->anticipate(
                "Choice the column type", 
                ["string", "enum", "integer", "float", "boolean", "date", "datetime", "time", "file", "json", "relationship"], 
                "string"
            );
            $columns[$column]['type'] = $type;
            
            // ask if the column not null
            $isNull = $this->ask("The column is nullable ?", "Yes");
            $columns[$column]['nullable'] = $isNull=="Yes";

            // ask specified questions
            switch ($type) {
                case 'file':
                    # code...
                    break;
                case 'enum':
                    # code...
                    break;
                case 'relationship':
                    # code...
                    break;
            }
        }

        return $columns;
    }

    private function loadModels()
    {
        // Get all PHP files in the "app" directory
        $files = File::glob(app_path('Models/*.php'));
            
        // Define an array to store model names
        $names = [];
        
        // Iterate through each file
        foreach ($files as $file) {
            // Get the file name without the extension
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $fileNamePath = "App\\Models\\".$fileName;
        
            // Check if the class exists in the file
            if (class_exists($fileNamePath)) {
                // Check if the class extends Eloquent\Model (assuming you are using Eloquent)
                $reflector = new ReflectionClass($fileNamePath);
                if (
                    $reflector->isSubclassOf('Illuminate\Database\Eloquent\Model')
                    ||
                    $reflector->isSubclassOf('Illuminate\Foundation\Auth\User')
                ) {
                    $names[] = $fileNamePath;
                }
            }
        }

        return $names;
    }
}