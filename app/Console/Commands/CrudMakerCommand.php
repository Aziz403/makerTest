<?php

namespace App\Console\Commands;

use App\Traits\ControllerHelper;
use App\Traits\ViewHelper;
use Illuminate\Console\Command;
use App\Traits\ModelHelper;

class CrudMakerCommand extends Command
{
    use ModelHelper;
    use ControllerHelper;
    use ViewHelper;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
    make:crud 
    {name : The name of the model to make CRUD for it}
    {--api}
    {--with-validation}
    {--with-factories}
    {--with-forms-models}
    {--with-datatable}
    {--with-tom-select}
    {--with-dropzone}
    {--export-pdf}
    {--export-excel}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public array $todo = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->todo = [];
        $model = null;

        if(!$this->checkModel()) 
            $model = $this->createModel();
        else 
            $model = $this->loadModel();

        if($this->option('api'))
            $this->createApiController($model);
        else{
            $this->createController($model);
            $this->createViews($model);
        }
    }
}
