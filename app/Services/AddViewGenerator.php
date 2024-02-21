<?php

namespace App\Services;

class AddViewGenerator extends FileGenerator
{
    protected $info;

    public function __construct($info) {
        parent::__construct(strtolower($info->modelName));
        $this->info = $info;
    }

    public function addBody() {
        $this->code .= "<h1>New {$this->info->modelName}</h1>\n\n";

        $this->code .= "<form action=\"{{ route('{$this->lname}s.store') }}\" method='POST'>\n";
        $this->code .= "\t@csrf\n";
        $this->code .= "\t<table>\n";
        foreach ($this->info->columns as $col) {
            $lcol = strtolower($col);
            $this->code .= "\t\t<tr>\n";
            $this->code .= "\t\t\t<td><label>$col</label></td>\n";
            $this->code .= "\t\t\t<td><input name='$lcol'/></td>\n";
            $this->code .= "\t\t</tr>\n";
        }
        $this->code .= "\t\t<tr>\n";
        $this->code .= "\t\t\t<td></td>\n";
        $this->code .= "\t\t\t<td><input type='submit' value='New'/></td>\n";
        $this->code .= "\t\t</tr>\n";
        $this->code .= "\t</table>\n";
        $this->code .= "</form>\n";

        return $this;
    } 

    public function save()
    {
        parent::saveToFile("create");
    }
}