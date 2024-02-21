<?php

namespace App\Services;

use Illuminate\Support\Facades\App;

class MigrationGenerator
{
    protected $code;

    public function __construct(protected $tableName, protected $columns = []) {
        $this->code = "<?php\n\n";    
        $this->code .= "use Illuminate\Database\Migrations\Migration;\n";
        $this->code .= "use Illuminate\Support\Facades\Schema;\n";
        $this->code .= "use Illuminate\Database\Schema\Blueprint;\n\n";
        
        $this->code .= "return new class extends Migration\n";
        $this->code .= "{\n";
        $this->code .= "/**\n";
        $this->code .= "* Run the migrations.\n";
        $this->code .= "*/\n\n";
        $this->code .= "\tpublic function up(): void\n";
        $this->code .= "\t{\n";
        $this->code .= "\tSchema::create('$this->tableName', function (Blueprint \$table) {\n";
        $this->code .= "\t\t\$table->id();\n";

        foreach($columns as $name => $config)
        {
            switch ($config['type']) {
                case 'file':
                    # code...
                    break;
                case 'relationship':
                    # code...
                    break;
                case 'boolean':
                    $this->code .= "\t\t\$table->string('$name');\n";
                    break;
                default:
                    $this->code .= "\t\t\$table->{$config['type']}('$name');\n";
                    break;
            }
        }
        
        $this->code .= "\t\t\$table->timestamps();\n";
        $this->code .= "\t});\n";
        $this->code .= "\t}\n\n";
        $this->code .= "/**\n";
        $this->code .= "* Reverse the migrations.\n";
        $this->code .= "*/\n\n";
        $this->code .= "\tpublic function down(): void\n";
        $this->code .= "\t{\n";
        $this->code .= "\t\tSchema::dropIfExists('$this->tableName');\n";
        $this->code .= "\t}\n\n";
        $this->code .= "};\n";
    }

    public function migrate()
    {

    }

    public function saveToFile() {
        $migrationsPath = database_path('migrations');
        file_put_contents($migrationsPath . "/{$this->$this->tableName}_migration.php", $this->code);
        return $this;
    }
}