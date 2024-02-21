<?php

namespace App\Services;

class CrudControllerGenerator extends ControllerGenerator
{
    protected $config;

    public function __construct($model, $uses, $config) {
        $uses[] = "Illuminate\\Http\\Request";
        $uses[] = "Illuminate\\Http\\Response";
        $uses[] = "App\\Models\\{$model['name']}";
        parent::__construct($model, $uses);
        $this->config = $config;
    }

    public function createCrud() {
        $lowerName = strtolower($this->model['name']);

        $this->addMethod(self::renderIndex($this->model, $lowerName, $this->config));
        $this->addMethod(self::renderCreate($this->model, $lowerName, $this->config));
        $this->addMethod(self::renderStore($this->model, $lowerName, $this->config));
        $this->addMethod(self::renderShow($this->model, $lowerName, $this->config));
        $this->addMethod(self::renderEdit($this->model, $lowerName, $this->config));
        $this->addMethod(self::renderUpdate($this->model, $lowerName, $this->config));
        $this->addMethod(self::renderDestroy($this->model, $lowerName, $this->config));

        $this->code .= "\t\n";
        $this->code .= "}\n";

        return $this;
    }

    public static function renderIndex($model, $lname, $config)
    {
        $name = $model['name'];
        $body = [];

        if(isset($config['with-datatable']) && $config['with-datatable'])
            $body[] = "\${$lname}s = $name::all();";// TODO: change by datatable usage
        else
            $body[] = "\${$lname}s = $name::all();";
        $body[] = "";
        if(isset($config['api']) && $config['api'])
            $body[] = "return response()->json(['data' => \${$lname}s]);";
        else
            $body[] = "return view('{$lname}s.index', compact('{$lname}s'));";

        return (new MethodGenerator())
            ->setName('index')
            ->setComment("Display a listing of the resource.")
            ->setBody($body)
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters([]);
    }

    public static function renderCreate($model, $lname, $config)
    {
        $name = $model['name'];

        if(isset($config['with-form-model']) && $config['with-form-model'])  return;
        if(isset($config['api']) && $config['api'])  return;

        return (new MethodGenerator())
            ->setName('create')
            ->setComment("Show the form for creating a new post.")
            ->setBody([
                "return view('{$lname}s.create');",
            ])
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters([]);
    }

    public static function renderStore($model, $lname, $config)
    {
        $name = $model['name'];
        $body = [];

        if(!isset($config['with-validation'])){
            $body[] = "\$request->validate([";
            $body[] = "//...\$validationRules,"; // TODO: change by real request validation values from ValidationHelper::rules($model)
            $body[] = "]);";
        }
        
        $body[] = "";
        $body[] = "$name::create(\$request->all());";
        $body[] = "";
        
        if(isset($config['api']) && $config['api']){
            $body[] = "return response()->json(['success' => '$name created successfully']);";
        }
        else{
            $body[] = "return redirect()->route('{$lname}s.index')";
            $body[] = "\t->with('success', '$name created successfully');";
        }

        return (new MethodGenerator())
            ->setName('store')
            ->setComment("Store a newly created resource in storage.")
            ->setBody($body)
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters(['Request $request']);
    }

    public static function renderShow($model, $lname, $config)
    {
        $name = $model['name'];
        $body = [];
        
        $body[] = "$$lname = $name::find(\$id);";
        $body[] = "";
        
        if(isset($config['api']) && $config['api'])
            $body[] = "return response()->json(['data' => \${$lname}]);";
        else
            $body[] = "return view('{$lname}s.show', compact('$lname'));";

        return (new MethodGenerator())
            ->setName('show')
            ->setComment("Display the specified resource.")
            ->setBody($body)
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters(['$id']);
    }

    public static function renderEdit($model, $lname, $config)
    {
        $name = $model['name'];
        if(isset($config['with-form-model']) && $config['with-form-model'])  return;
        if(isset($config['api']) && $config['api'])  return;

        return (new MethodGenerator())
            ->setName('edit')
            ->setComment("Show the form for creating a new post.")
            ->setBody([
                "return view('{$lname}s.edit');",
            ])
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters([]);
    }

    public static function renderUpdate($model, $lname, $config)
    {
        $name = $model['name'];
        $body = [];

        if(!isset($config['with-validation'])){
            $body[] = "\$request->validate([";
            $body[] = "//...\$validationRules,"; // TODO: change by real request validation values from ValidationHelper::rules($model)
            $body[] = "]);";
        }
        
        $body[] = "";
        $body[] = "\${$lname} = $name::find(\$id);";
        $body[] = "\${$lname}->update(\$request->all());";
        $body[] = "";
        
        if(isset($config['api']) && $config['api']){
            $body[] = "return response()->json(['success' => '$name updated successfully']);";
        }
        else{
            $body[] = "return redirect()->route('{$lname}s.index')";
            $body[] = "\t->with('success', '$name updated successfully.');";
        }

        return (new MethodGenerator())
            ->setName('update')
            ->setComment("Update the specified resource in storage.")
            ->setBody($body)
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters(['Request $request', '$id']);
    }

    public static function renderDestroy($model, $lname, $config)
    {
        $name = $model['name'];
        $body = [];

        $body[] = "\${$lname} = $name::find(\$id);";
        $body[] = "\${$lname}->delete();";
        $body[] = "";
        
        if(isset($config['api']) && $config['api']){
            $body[] = "return response()->json(['success' => '$name deleted successfully']);";
        }
        else{
            $body[] = "return redirect()->route('{$lname}s.index')";
            $body[] = "\t->with('success', '$name deleted successfully.');";
        }

        return (new MethodGenerator())
            ->setName('destroy')
            ->setComment("Remove the specified resource from storage.")
            ->setBody($body)
            ->setReturnType('\Illuminate\Http\Response')
            ->setParameters(['$id']);
    }
}