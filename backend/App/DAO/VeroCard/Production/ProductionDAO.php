<?php

namespace App\DAO\VeroCard\Production;

use App\DAO\VeroCard\Connection;


class ProductionDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProductsInProductionTarja(): array
    {
        $products = $this->pdo
            ->query("SELECT * from view_verocard_production_tarja;")->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
        }

        return $products;
    }

    public function getAllProductsInProductionChip(): array
    {
        $products = $this->pdo
            ->query("SELECT * from view_verocard_production_chip;")->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
        }

        return $products;
    }

    public function getAllProductsInProductionElo(): array
    {
        $products = $this->pdo
            ->query("SELECT * FROM view_verocard_production_elo WHERE desc_produto = 'VEROCARD+ ELO' AND (dt_expedicao IS NULL OR dt_expedicao = '1970-01-01');")
            ->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
        }

        return $products;
    }
}
