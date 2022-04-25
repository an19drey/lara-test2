<?php


namespace App\Models\Sources\Db;

use App\Models\Sources\ISource;
use Illuminate\Support\Facades\DB;

class DbSource implements ISource
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get(int $limit, int $offset): array
    {
        return DB::table('transactions')
            ->select('*')
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->toArray();
    }
}
