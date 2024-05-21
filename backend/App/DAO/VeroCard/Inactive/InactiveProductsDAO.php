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
        $query = "SELECT * FROM view_redeuze_relatorio_inativos ";
    
        $inactiveProducts = $this->pdo
            ->query($query)
            ->fetchAll(\PDO::FETCH_ASSOC);
    
        return $inactiveProducts;
    }
    
    public function searchInactiveProducts($searchTerm): array
    {
        $searchTerm = '%' . $searchTerm . '%';
    
        $query = "SELECT * FROM view_redeuze_relatorio_inativos 
                  WHERE (cod_produto LIKE :searchTerm 
                  OR desc_produto LIKE :searchTerm)";
    
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
        $statement->execute();
    
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
        return $results;
    }
    
    
}
