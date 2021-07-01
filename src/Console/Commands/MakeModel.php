<?php

namespace Tnchalise\Tiks\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class MakeModel extends ModelMakeCommand
{
    protected $name = 'make:model';
    protected $description = 'Create a new Eloquent model class';
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
