<?php

namespace App\Services;

class ControllerGenerator
{
    protected $code;

    public function __construct(protected $model, protected $uses = []) {
        $this->code = "<?php\nnamespace App\\Http\\Controllers;\n\n";
        foreach($this->uses as $use)
        {
            $this->code .= "use $use;\n";
        }
        $this->code .= "\nclass {$model['name']}Controller extends Controller {\n";
        //$this->code .= "\n\t";
        //$this->code .= "\n\t".self::STR_COMMENT_CONTROLLER."\n";
        //$this->code .= "\n\t";
        //$this->code .= "}\n";
            
    }

    public function addMethod(MethodGenerator|null $method) {
        if(!$method) return;
        
        $this->code .= $method->toString();
        $this->code .= "\n";
        //$this->code .= "\n\t".self::STR_COMMENT_CONTROLLER."\n";

        //str_replace(self::STR_COMMENT_CONTROLLER, $method->toString(), $this->code);
    }

    public function generate() {
        file_put_contents(app_path("Http/Controllers/{$this->model['name']}Controller.php"), $this->code);
    }    
}