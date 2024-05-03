<?php

namespace App\DAO\VeroCard\Graph;

use App\DAO\VeroCard\Connection;

class GraphDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllGraph(): array
    {
        $graph = $this->pdo
            ->query("SELECT * FROM view_redeuze_grafico_site")
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $graph;
    }

   
}
