<?php

namespace App\Services;

class ShowViewGenerator extends FileGenerator
{
    protected $info;
    protected $lname;

    public function __construct($info) {
        parent::__construct(strtolower($info->modelName));
        $this->info = $info;
    }

    public function addBody() {
        $this->code .= "<h1>Show {$this->info->modelName} #{{ \${$this->lname}->id }}</h1>\n\n";

        $this->code .= "<table>\n";
        foreach ($this->info->columns as $col) {
            $lcol = strtolower($col);
            $this->code .= "\t<tr>\n";
            $this->code .= "\t\t<td><label>$col</label></td>\n";
            $this->code .= "\t\t<td>{{ \${$this->lname}->$lcol }}</td>\n";
            $this->code .= "\t</tr>\n";
        }
        $this->code .= "\t<tr>\n";
        $this->code .= "\t\t<td></td>\n";
        $this->code .= "\t\t<td><a href=\"{{ route('{$this->lname}s.edit', \${$this->lname}->id) }}\">Edit</a>\n";
        $this->code .= "\t</tr>\n";
        $this->code .= "</table>";

        return $this;
    } 

    public function save()
    {
        parent::saveToFile("show");
    }
}