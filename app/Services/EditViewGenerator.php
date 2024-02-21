<?php

namespace App\Services;

class EditViewGenerator extends FileGenerator
{
    protected $info;
    protected $lname;

    public function __construct($info) {
        parent::__construct(strtolower($info->modelName));
        $this->info = $info;
    }

    public function addBody() {
        $this->code .= "<h1>Edit {$this->info->modelName} #{{ \${$this->lname}->id }}</h1>\n\n";

        $this->code .= "<form action=\"{{ route('{$this->lname}s.update', \${$this->lname}->id) }}\" method='POST'>\n";
        $this->code .= "\t@method('PUT')\n";
        $this->code .= "\t@csrf\n";
        $this->code .= "\t<table>\n";
        foreach ($this->info->columns as $col) {
            $lcol = strtolower($col);
            $this->code .= "\t\t<tr>\n";
            $this->code .= "\t\t\t<td><label>$col</label></td>\n";
            $this->code .= "\t\t\t<td><input name='$lcol' value='{{ \${$this->lname}->$lcol }}'/></td>\n";
            $this->code .= "\t\t</tr>\n";
        }
        $this->code .= "\t\t<tr>\n";
        $this->code .= "\t\t\t<td></td>\n";
        $this->code .= "\t\t\t<td><input type='submit' value='Update'/></td>\n";
        $this->code .= "\t\t</tr>\n";
        $this->code .= "\t</table>\n";
        $this->code .= "</form>\n";

        return $this;
    } 

    public function save()
    {
        parent::saveToFile("edit");
    }
}