<?php

namespace App\Services;

class FileGenerator
{
    protected $code;
    
    public function __construct(protected $lname) {
        $this->code = '';
    }

    public function addBodyFile($body) {
        $this->code .= $body;
    }

    public function saveToFile($filename) {
        $path = base_path('resources/views/'.$this->lname);
        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0755, true, true);
        }        
        file_put_contents($path."/$filename.blade.php", $this->code);
    }   
}