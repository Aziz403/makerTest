<?php

namespace App\Services;

class MethodGenerator
{
    private $code;

    private string $name;
    private array|null $parameters = null;
    private array|string $body = '';
    private string $comment = '';
    private string $returnType = '\Illuminate\Http\Response';

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function setParameters($parameters) {
        $this->parameters = $parameters;

        return $this;
    }

    public function setBody($body) {
        $this->body = $body;

        return $this;
    }

    public function setComment($comment) {
        $this->comment = $comment;

        return $this;
    }

    public function setReturnType($returnType) {
        $this->returnType = $returnType;

        return $this;
    }

    public function __construct() {
        $this->code = '';
    }

    public function toString() {
        $parametersList = $this->parameters ? implode(', ', $this->parameters) : '';
        $this->code .= "\t\n";
        $this->code .= "\t/**\n";
        $this->code .= "\t* $this->comment\n";
        $this->code .= "\t*\n";
        $this->code .= "\t* @return \Illuminate\Http\Response\n";
        $this->code .= "\t*/\n";
        $this->code .= "\tpublic function $this->name($parametersList) {\n";
        if(is_array($this->body)){
            foreach($this->body as $line){
                $this->code .= "\t\t$line\n";
            }
        }
        else $this->code .= "\t\t$this->body\n";
        $this->code .= "\t}\n";
        return $this->code;
    }
}