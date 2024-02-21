<?php

namespace App\Traits;
use App\Services\CrudControllerGenerator;

trait ControllerHelper
{
    public function createApiController($model)
    {
        $isValidationEnabled = $this->option('with-validation');
        $isDatatableEnabled = $this->option('with-datatable');
        //$isFormsModelsEnabled = $this->option('with-forms-models');
        //$isTomSelectEnabled = $this->option('with-tom-select');
        //$isDropzoneEnabled = $this->option('with-dropzone');
        //$isExportPdfEnabled = $this->option('export-pdf');
        //$isExportExcelEnabled = $this->option('export-excel');
        //$isImportExcelEnabled = $this->option('import-excel');
        
        $generator = new CrudControllerGenerator($model, [], $this->options());
        $generator->createCrud();
        $generator->generate();

        if($this->option('with-validation')){
            $this->createRequestValidation();
        }
    }   

    public function createController($model)
    {
        $isValidationEnabled = $this->option('with-validation');
        $isDatatableEnabled = $this->option('with-datatable');
        $isFormsModelsEnabled = $this->option('with-forms-models');
        //$isTomSelectEnabled = $this->option('with-tom-select');
        //$isDropzoneEnabled = $this->option('with-dropzone');
        //$isExportPdfEnabled = $this->option('export-pdf');
        //$isExportExcelEnabled = $this->option('export-excel');
        //$isImportExcelEnabled = $this->option('import-excel');
        
        $generator = new CrudControllerGenerator($model, [], $this->options());
        $generator->createCrud();
        $generator->generate();

        if($this->option('with-validation')){
            $this->createRequestValidation();
        }
    }
}