<?php

namespace App\Services;

class ModelGenerator
{
    public static $PROP_TYPES = [
        "string",
        "integer",
        "float",
        "boolean",
        "date",
        "datetime",
        "time",
        "file",
        "json",
        "relationship",
    ];

    protected $code;

    public function __construct(
        protected $name, 
        protected $uses = ["Illuminate\Database\Eloquent\Factories\HasFactory", "Illuminate\Database\Eloquent\Model"], 
        protected $columns = []) {
        $this->code = "<?php\nnamespace App\\Http\\Controllers;\n\n";
        foreach($this->uses as $use)
        {
            $this->code .= "use $use;\n\n";
        }
        $this->code .= "class {$name} extends Model {\n";
        $this->code .= "\n\t";
        $this->code .= "\n\tuse HasFactory;\n";
        $this->code .= "\n\tprotected \$fillable = [];\n";
        $this->code .= "\n\t";
        $this->code .= "}\n";
            
    }

    public function saveToFile() {
        file_put_contents(app_path("Models/{$this->name}.php"), $this->code);
    }    
}