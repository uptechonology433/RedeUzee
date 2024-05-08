<?php

namespace App\DAO\VeroCard\ProductionReport;

use App\DAO\VeroCard\Connection;
use App\Models\ProductionReportModel;

class ProductionReportDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductionReportFilterFileDAO(ProductionReportModel $productionReportModel): array
    {

        $statement = $this->pdo->prepare("SELECT
         to_char(dt_processamento, 'DD/MM/YYYY') AS dt_processamento, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
      
        total_cartoes, status from view_redeuze_producao WHERE nome_arquivo_proc = :arquivo");

        $statement->execute(['arquivo' => $productionReportModel->getFile()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getProductionReportFilterDateDAO(ProductionReportModel $productionReportModel): array
    {

        $statement = $this->pdo->prepare("SELECT 
      
         to_char(dt_processamento, 'DD/MM/YYYY') AS dt_processamento, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
      
        total_cartoes, status from view_redeuze_producao where dt_processamento BETWEEN :datainicial AND :datafinal ;");

        $statement->execute(['datainicial' => $productionReportModel->getInitialProcessinDate(), 'datafinal' => $productionReportModel->getFinalProcessinDate()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getProductionReportFilterShippingDAO(ProductionReportModel $productionReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT
     
         to_char(dt_processamento, 'DD/MM/YYYY') AS dt_processamento, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
        total_cartoes, status from view_redeuze_producao where dt_expedicao BETWEEN :expedicaoinicial AND :expedicaofinal ;");

        $statement->execute(['expedicaoinicial' => $productionReportModel->getInitialShippingdate(), 'expedicaofinal' => $productionReportModel->getFinalShippingdate()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getProductionReportFilterDatesAndShippingDAO(ProductionReportModel $productionReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT
        to_char(dt_processamento, 'DD/MM/YYYY') AS dt_processamento,
        to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
        nome_arquivo_proc,
        total_cartoes,
        status 
    FROM 
        view_redeuze_producao 
    WHERE 
        dt_processamento BETWEEN :datainicial AND :datafinal
        AND dt_expedicao BETWEEN :expedicaoinicial AND :expedicaofinal ;");

        $statement->execute([
            'datainicial' => $productionReportModel->getInitialProcessinDate(),
            'datafinal' => $productionReportModel->getFinalProcessinDate(),
            'expedicaoinicial' => $productionReportModel->getInitialShippingdate(),
            'expedicaofinal' => $productionReportModel->getFinalShippingdate()
        ]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }


   
}
