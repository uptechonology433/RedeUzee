<?php

namespace App\DAO\VeroCard\Dispatched;
use App\DAO\VeroCard\Connection;


class DispatchedDAO extends Connection{

    public function __construct()
    {
        parent::__construct();
    }

  

    
    public function getAllDispatched() : array {

        $productsDispatched  = $this -> pdo
            ->query("SELECT  * FROM view_redeuze_dispatched;")
            ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($productsDispatched as &$product) {
                $product['dt_processamento'] = date('d/m/Y', strtotime($product['dt_processamento']));
                $product['dt_expedicao'] = date('d/m/Y', strtotime($product['dt_expedicao']));
            }

            return $productsDispatched ;

    }


}