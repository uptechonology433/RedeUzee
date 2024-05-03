<?php

namespace App\DAO\VeroCard\Ruptures;

use App\DAO\VeroCard\Connection;

class RupturesProductsDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

 public function getAllRupturesProducts(): array
{
    $query = "SELECT * FROM view_combined_ruptura_dmcard WHERE LENGTH(\"COD PROD\") = 5";
    
    $rupturesProducts = $this->pdo
        ->query($query)
        ->fetchAll(\PDO::FETCH_ASSOC);
    
    return $rupturesProducts;
}

public function searchRuptureProducts($searchTerm): array
{
    $searchTerm = '%' . $searchTerm . '%';

    $query = "SELECT * FROM view_combined_ruptura_dmcard 
              WHERE (\"COD PROD\" LIKE :searchTerm 
              OR \"PRODUTO\" LIKE :searchTerm)
              AND LENGTH(\"COD PROD\") = 5";

    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
    $statement->execute();

    $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return $results;
}

    
}
