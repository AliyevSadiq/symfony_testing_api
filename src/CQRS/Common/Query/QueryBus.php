<?php

namespace App\CQRS\Common\Query;

interface QueryBus
{
    /** @return mixed */
    public function handle(Query $query);
}