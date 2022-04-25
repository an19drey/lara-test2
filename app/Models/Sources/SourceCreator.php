<?php


namespace App\Models\Sources;

abstract class SourceCreator
{
    abstract public function createSource(): ISource;

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get(int $limit, int $offset): array
    {
        $source = $this->createSource();
        $result = $source->get($limit, $offset);

        return $result;
    }
}
