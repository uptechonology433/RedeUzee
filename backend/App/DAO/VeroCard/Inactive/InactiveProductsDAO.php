<?php

namespace App\DAO\VeroCard\Inactive;

use App\DAO\VeroCard\Connection;

class InactiveProductsDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllInactiveProducts(): array
    {
        $query = "SELECT * FROM view_dmcard_relatorio_produtos_inativos WHERE desc_produto LIKE '%- UZE'";
    
        $inactiveProducts = $this->pdo
            ->query($query)
            ->fetchAll(\PDO::FETCH_ASSOC);
    
        return $inactiveProducts;
    }
    
    public function searchInactiveProducts($searchTerm): array
    {
        $searchTerm = '%' . $searchTerm . '%';
        $searchTermWithSuffix = $searchTerm . '- UZE%';
    
        $query = "SELECT * FROM view_dmcard_relatorio_produtos_inativos 
                  WHERE (cod_produto LIKE :searchTerm 
                  OR desc_produto LIKE :searchTerm)
                  AND desc_produto LIKE :searchTermWithSuffix";
    
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
        $statement->bindParam(':searchTermWithSuffix', $searchTermWithSuffix, \PDO::PARAM_STR);
        $statement->execute();
    
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
        return $results;
    }
    
}
