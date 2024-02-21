<?php

namespace App\Services;

class CrudCLassGenerator extends CLassGenerator
{
    public function __construct(
        $name, 
        $uses = [
            "\\Illuminate\\Http\\Request",
            "\\Illuminate\\Http\\Response"
        ]
    ) {
        $uses[] = "App\\Models\\$name";
        parent::__construct($name, $uses);
    }

    public function addCrudMethod() {
        $lowerName = strtolower($this->name);

        $index = new MethodGenerator();
        $index->setName('index');
        $index->setComment("Display a listing of the resource.");
        $index->setBody([
            "\${$lowerName}s = $this->name::all();",
            "",
            "return view('{$lowerName}s.index', compact('{$lowerName}s'));",
        ]);
        $index->setReturnType('\Illuminate\Http\Response');
        $index->setParameters([]);
        
        $create = new MethodGenerator();
        $create->setName('create');
        $create->setComment("Show the form for creating a new post.");
        $create->setBody([
            "return view('{$lowerName}s.create');",
        ]);
        $create->setReturnType('\Illuminate\Http\Response');
        $create->setParameters([]);
        
        $store = new MethodGenerator();
        $store->setName('store');
        $store->setComment("Store a newly created resource in storage.");
        $store->setBody([
            "\$request->validate([",
            //...$validationRules,
            "]);",
            "$this->name::create(\$request->all());",
            "",
            "return redirect()->route('{$lowerName}s.index')",
            "\t->with('success', '$this->name created successfully.');",
        ]);
        $store->setReturnType('\Illuminate\Http\Response');
        $store->setParameters(['Request $request']);

        $show = new MethodGenerator();
        $show->setName('show');
        $show->setComment("Display the specified resource.");
        $show->setBody([
            "$$lowerName = $this->name::find(\$id);",
            "return view('{$lowerName}s.show', compact('$lowerName'));",
        ]);
        $show->setReturnType('\Illuminate\Http\Response');
        $show->setParameters(['$id']);
        
        $edit = new MethodGenerator();
        $edit->setName('edit');
        $edit->setComment("Show the form for creating a new post.");
        $edit->setBody([
            "return view('{$lowerName}s.edit');",
        ]);
        $edit->setReturnType('\Illuminate\Http\Response');
        $edit->setParameters([]);
        
        $update = new MethodGenerator();
        $update->setName('update');
        $update->setComment("Update the specified resource in storage.");
        $update->setBody([
            "\$request->validate([",
            //...$validationRules,
            "]);",
            "\${$lowerName} = $this->name::find(\$id);",
            "\${$lowerName}->update(\$request->all());",
            "",
            "return redirect()->route('{$lowerName}s.index')",
            "\t->with('success', '$this->name updated successfully.');",
        ]);
        $update->setReturnType('\Illuminate\Http\Response');
        $update->setParameters(['Request $request', '$id']);
        
        $delete = new MethodGenerator();
        $delete->setName('destroy');
        $delete->setComment("Remove the specified resource from storage.");
        $delete->setBody([
            "\${$lowerName} = $this->name::find(\$id);",
            "\${$lowerName}->delete();",
            "",
            "return redirect()->route('{$lowerName}s.index')",
            "\t->with('success', '$this->name deleted successfully.');",
        ]);
        $delete->setReturnType('\Illuminate\Http\Response');
        $delete->setParameters(['$id']);

        $this->addMethod($index);
        $this->addMethod($create);
        $this->addMethod($store);
        $this->addMethod($show);
        $this->addMethod($edit);
        $this->addMethod($update);
        $this->addMethod($delete);

        $this->code .= "\t\n";
        $this->code .= "}\n";

        return $this;
    }

    public function saveToFile() {
        file_put_contents(app_path("Http/Controllers/{$this->name}Controller.php"), $this->code);
    }    
}