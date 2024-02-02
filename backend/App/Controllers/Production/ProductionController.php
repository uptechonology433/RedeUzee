<?php
namespace App\Controllers\Production;
use App\DAO\VeroCard\Production\ProductionDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;

final class ProductionController
{   

    public function Productsinproduction(Request $request, Response $response, array $args): Response
    {

        $data = $request->getParsedBody();
        strtoupper(trim($data['tipo'])); 
      
        
        $productionDAO = new ProductionDAO();
        

        if($data['tipo'] == 'tarja'){
            
            $production = $productionDAO -> getAllProductsInProductionTarja($data['tipo']);

        }elseif($data['tipo'] == 'chip'){

            $production = $productionDAO -> getAllProductsInProductionChip($data['tipo']);
            
        }elseif ($data['tipo'] == 'elo'){

            $production = $productionDAO -> getAllProductsInProductionElo($data['tipo']);
    }

       
        
        $response = $response -> withJson($production);

        return $response;
    }
}

?>