<?php
namespace App\Models\Sources\Csv;

use App\Models\Sources\ISource;
use App\Models\Sources\SourceCreator;

class CsvCreator extends SourceCreator
{
    public function createSource(): ISource
    {
        return new CsvSource();
    }
}
