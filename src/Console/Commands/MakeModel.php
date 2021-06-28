<?php

namespace Tnchalise\Tiks\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeModel extends GeneratorCommand
{
    protected $name = 'make:recordable-model';
    protected $description = 'Make a model that implements Altek Accountant';
    protected $type = 'Model';

    protected function getDefaultNamespace($rootNamespace)
    {
        return sprintf("%s\Models", $rootNamespace);
    }

    public function getStub()
    {
        return resource_path('stubs/ModelStub.php');
    }
}
