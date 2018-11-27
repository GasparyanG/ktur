<?php
namespace DataBase\Interfaces;

interface TableInterface
{
    /**
     * @return string SQL statement for tabel creation
     *      e.g. CREATE TABLE IF NOT EXISTS users(
     *      column_name constraints (INT, AUTO_INCREMENT, etc.)
     * )
     */
    public static function getTableDef();
}