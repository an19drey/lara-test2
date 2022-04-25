<?php
namespace App\Models\Sources;

interface ISource
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get(int $limit, int $offset): array;
}
