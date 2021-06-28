<?php

namespace Tnchalise\Tiks\Models;

use Illuminate\Database\Eloquent\Model;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;
use Altek\Eventually\Eventually as EventuallyTrait;

abstract class RecordableModel extends Model implements Recordable
{
    use RecordableTrait, EventuallyTrait;

    protected $recordableEvents = [
        'created',
        'updated',
        'restored',
        'deleted',
        'forceDeleted',
        'existingPivotUpdated',
        'attached',
        'detached',
    ];
}
