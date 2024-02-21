<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use ReflectionClass;

trait ModelInfoHandler
{
    public function fetchOrAdd()
    {
        $model = $this->argument("model");
        $modelNames = $this->getModels();
        $info = null;

        if (in_array("App\\Models\\$model", $modelNames)) {
            $info = new ModelInfo($model);
        } else {
            // ask to create the model
            $ask = $this->ask("$model Model does not exist! Do you want to create this model?", 'Yes');
            if ($ask == "Yes") {
                // add the columns
                $columns = [];
                while (true) {
                    $column = $this->ask("Enter the column name");
                    if ($ask == "Stop") break;
                    $columns[$column] = [];
                    $type = $this->anticipate("Enter the column type", ModelGenerator::$PROP_TYPES, "string");
                    $columns[$column]['type'] = $type;
                    switch ($type) {
                        case 'file':
                            # code...
                            break;
                        case 'relationship':
                            # code...
                            break;
                    }
                }
                $tableName = $model;
                // generate the model
                ModelGenerator::makeModel($tableName);
                $this->info('The model created successfully!');
                // generate the migration
                (new MigrationGenerator($tableName, $columns))->saveToFile();//->migrate(); // TODO:  should create migrate function
                $this->info('The migration created successfully!');
                // load the info
                $info = new ModelInfo($model);
            }
        }

        return $info;
    }

    private function getModels()
    {
        // Get all PHP files in the "app" directory
        $files = File::glob(app_path('Models/*.php'));
            
        // Define an array to store model names
        $modelNames = [];
        
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
                    $modelNames[] = $fileNamePath;
                }
            }
        }

        return $modelNames;
    }
}