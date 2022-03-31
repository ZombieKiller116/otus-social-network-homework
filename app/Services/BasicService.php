<?php

namespace App\Services;

abstract class BasicService
{
    protected function getFirst(array $data)
    {
        return $data[0];
    }

    protected function getColumn(string $column, array $data): array
    {
        return array_map(function ($item) use ($column) {
            return $item->$column;
        }, $data);
    }

    protected function getCountValue($data)
    {
        return $data[0]->{"COUNT(*)"};
    }

    protected function convertArrayForSqlIn(array $friendIds): string
    {
        return implode(',', $friendIds);
    }
}
