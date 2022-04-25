<?php
namespace App\Models\Sources\Db;

use App\Models\Sources\ISource;
use App\Models\Sources\SourceCreator;

class DbCreator extends SourceCreator
{
    public function createSource(): ISource
    {
        return new DbSource();
    }
}
