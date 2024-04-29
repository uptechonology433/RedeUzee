<?php

namespace App\DAO\VeroCard\CardsIssuedReport;

use App\DAO\VeroCard\Connection;
use App\Models\CardsIssuedReportModel;

class CardsIssuedReportDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCardsIssuedReportFilterFileRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {

        $statement = $this->pdo->prepare("SELECT  titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
        desc_status from view_redeuze_relatorio_cartoes WHERE nome_arquivo_proc = :arquivo");

        $statement->execute(['arquivo' => $CardsIssuedReportModel->getFile()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getCardsIssuedReportFilterDateRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {

        $statement = $this->pdo->prepare("SELECT  titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status  from view_redeuze_relatorio_cartoes  where dt_op BETWEEN :datainicial AND :datafinal ;");

        $statement->execute(['datainicial' => $CardsIssuedReportModel->getInitialProcessinDate(), 'datafinal' => $CardsIssuedReportModel->getFinalProcessinDate()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getCardsIssuedReportFilterShippingRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT  titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op,  
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status from view_redeuze_relatorio_cartoes  where dt_expedicao BETWEEN :expedicaoinicial AND :expedicaofinal ;");

        $statement->execute(['expedicaoinicial' => $CardsIssuedReportModel->getInitialShippingdate(), 'expedicaofinal' => $CardsIssuedReportModel->getFinalShippingdate()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }


    public function getCardsIssuedReportFilterDatesInGeneralRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status FROM view_redeuze_relatorio_cartoes  where dt_expedicao BETWEEN :expedicaoinicial AND :expedicaofinal OR dt_op BETWEEN :datainicial AND :datafinal;");

        $statement->execute(['expedicaoinicial' => $CardsIssuedReportModel->getInitialShippingdate(), 'expedicaofinal' => $CardsIssuedReportModel->getFinalShippingdate(), 'datainicial' => $CardsIssuedReportModel->getInitialProcessinDate(), 'datafinal' => $CardsIssuedReportModel->getFinalProcessinDate()]);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }


    public function getCardsIssuedReportFilterHolderRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status FROM view_redeuze_relatorio_cartoes  WHERE titular LIKE :titular");

        $statement->execute(['titular' => '%' . $CardsIssuedReportModel->getHolder() . '%']);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getCardsIssuedReportFilterAccountCodeRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status FROM view_redeuze_relatorio_cartoes  WHERE codigo_conta LIKE :codigo_conta");

        $statement->execute(['codigo_conta' => '%' . $CardsIssuedReportModel->getAccountCode() . '%']);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getCardsIssuedReportFilterCardCodeRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status FROM view_redeuze_relatorio_cartoes  WHERE codigo_cartao LIKE :codigo_cartao");

        $statement->execute(['codigo_cartao' => '%' . $CardsIssuedReportModel->getCardCode() . '%']);

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

  
    
    public function getCardsIssuedReportFilterStatusInProductionRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status FROM view_redeuze_relatorio_cartoes  WHERE desc_status LIKE 'EM PRODUÇÃO'");

        $statement->execute();

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public function getCardsIssuedReportFilterStatusDispatichedRedeUzeDAO(CardsIssuedReportModel $CardsIssuedReportModel): array
    {
        $statement = $this->pdo->prepare("SELECT titular, nr_cartao,rastreio,
        codigo_conta,desc_status,codigo_cartao,
         to_char(dt_op, 'DD/MM/YYYY') AS dt_op, 
         to_char(dt_expedicao, 'DD/MM/YYYY') AS dt_expedicao,
         nome_arquivo_proc,
         desc_status FROM view_redeuze_relatorio_cartoes  WHERE desc_status LIKE 'EXPEDIDO'");

        $statement->execute();

        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }
}
