<?php

namespace App\Ccu\Core\Cache;

trait Rememberable
{
    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        return new Builder($conn, $conn->getQueryGrammar(), $conn->getPostProcessor());
    }
}
