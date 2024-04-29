<?php

namespace App\DAO\VeroCard\AwaitingRelease;
use App\DAO\VeroCard\Connection;


class AwaitingReleaseDAO extends Connection{

    public function __construct()
    {
        parent::__construct();
    }


    
    public function getAllAwaitingRelease() : array {

        $productsAwaitingRelease = $this -> pdo
            ->query("SELECT  * FROM view_redeuze_awaitingRelease")
            ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($productsAwaitingRelease as &$product) {
                $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
              
            }

            return $productsAwaitingRelease;

        }


}