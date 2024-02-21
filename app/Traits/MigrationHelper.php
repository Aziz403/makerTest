<?php

namespace App\Traits;

trait MigrationHelper
{
    public function createMigration($name, $columns)
    {

        $this->todo[] = "Run the migration";
    }   
}