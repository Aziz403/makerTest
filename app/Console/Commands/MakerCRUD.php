<?php

namespace App\Console\Commands;

use App\Exceptions\ModelInfoException;
use App\Services\CrudCLassGenerator;
use App\Services\CrudViewGenerator;
use App\Services\ModelInfoHandler;
use Illuminate\Console\Command;

class MakerCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    
    protected $signature = 'maker:crud 
    {model? : The Name of the model to make CRUD for it} 
    {--style=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a CRUD from a model';    

    use ModelInfoHandler;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelInfo = $this->fetchOrAdd();
        $this->info('Table informations handled successfully!');
        
        (new CrudCLassGenerator($modelInfo->modelName))->addCrudMethod()->saveToFile();
        $this->info('Controller completed successfully!');

        CrudViewGenerator::generate($modelInfo);
        $this->info('views completed successfully!');

        $lname = strtolower($modelInfo->className);
        $cname = $modelInfo->className."Controller";
        $this->alert("Add in your router/web.php:   Route::ressource(\"/$lname\", $cname::class);");
    }
}
