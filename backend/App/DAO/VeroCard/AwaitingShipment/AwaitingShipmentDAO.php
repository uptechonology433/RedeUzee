<?php

namespace App\DAO\VeroCard\AwaitingShipment;
use App\DAO\VeroCard\Connection;


class AwaitingShipmentDAO extends Connection{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllAwaitingShipment() : array {

        $productsAwaitingShipment = $this -> pdo
            ->query("SELECT * FROM view_redeuze_AwaitingShipment;")
            ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($productsAwaitingShipment as &$product) {
                $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
              
            }

            return $productsAwaitingShipment;

    }

    


}