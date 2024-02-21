<?php

namespace App\Services;

use App\Services\AddViewGenerator;
use App\Services\EditViewGenerator;
use App\Services\IndexViewGenerator;
use App\Services\ShowViewGenerator;

class CrudViewGenerator
{
    public static function generate($info)
    {
        (new IndexViewGenerator($info))->addBody()->save();
        (new AddViewGenerator($info))->addBody()->save();
        (new EditViewGenerator($info))->addBody()->save();
        (new ShowViewGenerator($info))->addBody()->save();
    }
}
