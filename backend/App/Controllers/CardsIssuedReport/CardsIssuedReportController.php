<?php

namespace App\Controllers\CardsIssuedReport;

use App\DAO\VeroCard\CardsIssuedReport\CardsIssuedReportDAO;
use App\Models\CardsIssuedReportModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;

final class CardsIssuedReportController
{

    public function CardsIssuedReport(Request $request, Response $response, array $args): Response
    {

        $data = $request->getParsedBody();

        if (
            empty(trim($data['arquivo'])) &&
            empty(trim($data['titular'])) &&
            empty(trim($data['codigo_conta'])) &&
            empty(trim($data['codigo_cartao'])) &&
            empty(trim($data['desc_status'])) &&
            empty(trim($data['tipo'])) &&
            empty(trim($data['dataentrada'])) &&
            empty(trim($data['dataentradafinal'])) &&
            empty(trim($data['dataInicial'])) &&
            empty(trim($data['dataFinal'])) &&
            empty(trim($data['expedicaoInicial'])) &&
            empty(trim($data['expedicaoFinal']))
        ) {

            try {

                throw new \Exception("Preencha um dos campos para fazer a requisição");
            } catch (\Exception | \Throwable $ex) {

                return $response->withJson([
                    'error' => \Exception::class,
                    'status' => 400,
                    'code' => "002",
                    'userMessage' => 'Campos vazios, preencha um dos campos',
                    'developerMessage' => $ex->getMessage()
                ], 401);
            }
        }

        $cardsIssuedReportModel = new CardsIssuedReportModel();

        $cardsIssuedReportDAO = new CardsIssuedReportDAO();

        $cardsIssuedReportModel
            ->setFile(trim($data['arquivo']))
            ->setHolder(trim($data['titular']))
            ->setAccountCode(trim($data['codigo_conta']))
            ->setCardCode(trim($data['codigo_cartao']))
            ->setStatusInProduction(trim($data['desc_status']))
            ->setStatusDispatched(trim($data['desc_status']))
            ->setCardType(trim($data['tipo']))
            ->setInputDate(trim($data['dataentrada']))
            ->setInputDateFinish(trim($data['dataentradafinal']))
            ->setInitialProcessinDate(trim($data['dataInicial']))
            ->setFinalProcessinDate(trim($data['dataFinal']))
            ->setInitialShippingdate(trim($data['expedicaoInicial']))
            ->setFinalShippingdate(trim($data['expedicaoFinal']));


        if (!empty(trim($data['tipo'])) && $data['tipo'] === 'RedeUze') {
            // Verifica se o titular foi especificado
            if (!empty(trim($data['titular']))) {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['arquivo']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterHolderRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterFileHolderRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['codigo_conta']))) {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['arquivo']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterHolderRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterFileHolderRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['codigo_cartao']))) {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['arquivo']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterHolderRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterFileHolderRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['desc_status'])) && $data['desc_status'] === 'EmProducao') {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['codigo_conta']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusInProductionRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusInProductionAccontCodeRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['desc_status'])) && $data['desc_status'] === 'EmProducao') {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['codigo_cartao']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusInProductionRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusInProductionCardCodeRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['desc_status'])) && $data['desc_status'] === 'Expedido') {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['codigo_conta']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusDispatichedRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusDispatichedAccontCodeRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['desc_status'])) && $data['desc_status'] === 'Expedido') {
                // Se apenas o arquivo foi especificado, busca pelo titular
                if (empty(trim($data['codigo_cartao']))) {
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusDispatichedRedeUzeDAO($cardsIssuedReportModel);
                } else {
                    // Se ambos o arquivo e o titular foram especificados, busca por ambos
                    $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusDispatichedCardCodeRedeUzeDAO($cardsIssuedReportModel);
                }
            } else if (!empty(trim($data['arquivo']))) {
                // Se apenas o arquivo foi especificado
                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterFileRedeUzeDAO($cardsIssuedReportModel);
            }else if(!empty(trim($data['dataentrada'])) && !empty(trim($data['dataentradafinal']))){
                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterInputDateRedeUzeDAO($cardsIssuedReportModel);
            }else if (!empty(trim($data['codigo_conta']))) {
                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterAccountCodeRedeUzeDAO($cardsIssuedReportModel);
            } else if (!empty(trim($data['codigo_cartao']))) {
                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterCardCodeRedeUzeDAO($cardsIssuedReportModel);
            } else if (!empty(trim($data['desc_status'])) && $data['desc_status'] === 'EmProducao') {
                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusInProductionRedeUzeDAO($cardsIssuedReportModel);
            } else if (!empty(trim($data['desc_status'])) && $data['desc_status'] === 'Expedido') {
                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterStatusDispatichedRedeUzeDAO($cardsIssuedReportModel);
           
            } else if (
                !empty(trim($data['dataInicial'])) && !empty(trim($data['dataFinal']))
                && empty(trim($data['expedicaoInicial'])) && empty(trim($data['expedicaoFinal']))
            ) {

                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterDateRedeUzeDAO($cardsIssuedReportModel);
            } else if (
                !empty(trim($data['expedicaoInicial'])) && !empty(trim($data['expedicaoFinal']))
                && empty(trim($data['dataInicial'])) && empty(trim($data['dataFinal']))
            ) {

                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterShippingRedeUzeDAO($cardsIssuedReportModel);
            } else if (
                !empty(trim($data['expedicaoInicial'])) && !empty(trim($data['expedicaoFinal']))
                && !empty(trim($data['dataInicial'])) && !empty(trim($data['dataFinal']))
            ) {

                $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterDatesInGeneralRedeUzeDAO($cardsIssuedReportModel);
                // }else if (
                //     !empty(trim($data['arquivo']))
                //     &&!empty(trim($data['expedicaoInicial'])) && !empty(trim($data['expedicaoFinal']))
                //     && !empty(trim($data['dataInicial'])) && !empty(trim($data['dataFinal'])) 
                // ) {

                //     $cardsIssuedReport = $cardsIssuedReportDAO->getCardsIssuedReportFilterDatesFileInGeneralRedeUzeDAO($cardsIssuedReportModel);
            } else {

                $cardsIssuedReport = "Preencha os campos corretamente!";
            }
        }
        $response = $response->withJson($cardsIssuedReport);

        return $response;
    }
}
