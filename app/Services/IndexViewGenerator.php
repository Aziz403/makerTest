<?php

namespace App\Services;

class IndexViewGenerator extends FileGenerator
{
    protected $info;

    public function __construct($info) {
        parent::__construct(strtolower($info->modelName));
        $this->info = $info;
    }

    public function addBody() {        
        $this->code .= "<a href=\"{{ route('{$this->lname}s.create') }}\">Add</a>\n\n";

        $this->code .= "<table>\n";
        $this->code .= "\t<thead>\n";
        $this->code .= "\t\t<tr>\n";
        foreach ($this->info->columns as $col) {
            $this->code .= "\t\t\t<th>$col</th>\n";
        }
        $this->code .= "\t\t\t<th>actions</th>\n";
        $this->code .= "\t\t</tr>\n";
        $this->code .= "\t</thead>\n";
        $this->code .= "\t<tbody>\n";
        $this->code .= "\t\t@foreach(\${$this->lname}s as \${$this->lname})\n";
        $this->code .= "\t\t\t<tr>\n";
        foreach ($this->info->columns as $col) {
            $this->code .= "\t\t\t\t<td>{{ \${$this->lname}->{$col} }}</td>\n";
        }
        $this->code .= "\t\t\t\t<td>\n";
        $this->code .= "\t\t\t\t\t<a href=\"{{ route('{$this->lname}s.show', \${$this->lname}->id) }}\">Show</a>\n";
        $this->code .= "\t\t\t\t\t<a href=\"{{ route('{$this->lname}s.edit', \${$this->lname}->id) }}\">Edit</a>\n";
        $this->code .= "\t\t\t\t\t<a href=\"#\">Delete</a>\n";
        $this->code .= "\t\t\t\t</td>\n";
        $this->code .= "\t\t\t</tr>\n";
        $this->code .= "\t\t@endforeach\n";
        $this->code .= "\t</tbody>\n";
        $this->code .= "</table>\n";

        return $this;
    } 

    public function save()
    {
        parent::saveToFile("index");
    }
}