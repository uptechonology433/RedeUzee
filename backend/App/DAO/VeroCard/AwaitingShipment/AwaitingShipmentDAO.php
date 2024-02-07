<?php

namespace App\DAO\VeroCard\AwaitingShipment;
use App\DAO\VeroCard\Connection;


class AwaitingShipmentDAO extends Connection{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllAwaitingShipmentChip() : array {

        $productsAwaitingShipment = $this -> pdo
            ->query("SELECT  * FROM view_verocard_AwaitingShipment_chip;") 
            ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($productsAwaitingShipment as &$product) {
                $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
              
            }

            return $productsAwaitingShipment;

    }

    
    public function getAllAwaitingShipmentTarja() : array {

        $productsAwaitingShipment = $this -> pdo
            ->query("SELECT * FROM view_verocard_AwaitingShipment_tarja;")
            ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($productsAwaitingShipment as &$product) {
                $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
              
            }

            return $productsAwaitingShipment;

    }

    public function getAllAwaitingShipmentElo() : array {

        $productsAwaitingShipment = $this -> pdo
            ->query(" SELECT * from view_verocard_AwaitingShipment_elo;") 
            ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($productsAwaitingShipment as &$product) {
                $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
              
            }

            return $productsAwaitingShipment;

    }


}