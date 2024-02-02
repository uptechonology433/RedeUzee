<?php
namespace App\DAO\VeroCard\Production;
use App\DAO\VeroCard\Connection;


class ProductionDAO extends Connection{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProductsInProductionTarja(string $data) : array {
        $products = $this -> pdo
            ->query("SELECT * from view_verocard_producao_tarja;")->fetchAll(\PDO::FETCH_ASSOC);

            return $products;
    }

    public function getAllProductsInProductionChip(string $data) : array {
      $products = $this -> pdo
          ->query("SELECT * from view_verocard_producao_chip;")->fetchAll(\PDO::FETCH_ASSOC);

          return $products;
  }

  public function getAllProductsInProductionElo(string $data) : array {
    $products = $this -> pdo
        ->query("SELECT * from view_verocard_elo_producao;")->fetchAll(\PDO::FETCH_ASSOC);

        return $products;
}
}
