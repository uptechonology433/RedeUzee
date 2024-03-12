<?php

namespace App\DAO\VeroCard\Production;

use App\DAO\VeroCard\Connection;

class ProductionDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProductsInProduction(): array
    {
        $products = $this->pdo
            ->query("SELECT * FROM view_truckpag_production_tarja;")
            ->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));

         
            switch ($product['status']) {
                case 6:
                    $product['status'] = 'cofre';
                    break;
                case 2:
                    $product['status'] = 'personalização';
                    break;
                case 3:
                    $product['status'] = 'manuseio';
                    break;
                default:
                    $product['status'] = 'desconhecido';
                    break;
            }
        }

        return $products;
    }
}