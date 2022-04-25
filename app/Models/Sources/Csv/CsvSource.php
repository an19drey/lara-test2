<?php

namespace App\Models\Sources\Csv;

use App\Models\Sources\ISource;

class CsvSource implements ISource
{
    protected $file;

    /**
     * CsvSource constructor.
     * @param $filePath
     */
    public function __construct() {
        $this->file = fopen($this->getFilePath(), 'r');
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get(int $limit, int $offset): array
    {
        $result = [];

        $i = 0;
        foreach ($this->getDataFromCsv($limit, $offset) as $row) {
            $i++;
            if ($i == 1) {
                $header = $row;
            } else {
                $result[] = array_combine($header, $row);
            }
        }

        return $result;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return \Generator
     */
    protected function getDataFromCsv(int $limit, int $offset): \Generator
    {
        $i = 0;
        $newOffset = $offset + 1;
        while (!feof($this->file)) {
            $row = fgetcsv($this->file, 4096);
            $i++;

            if (($i >= ($newOffset + 1) && $i <= $newOffset + $limit) || $i == 1) {
                yield $row;
            }

            if ($i > $newOffset + $limit) {
                break;
            }
        }
    }

    /**
     * @return string
     */
    protected function getFilePath(): string
    {
        return config('source.type.csv.pathToFile');
    }
}
