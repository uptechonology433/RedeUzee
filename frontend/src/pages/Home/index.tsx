import React, { useEffect, useRef, useState } from "react";
import api from "../../connectionAPI";
import Table from "../../components/shared/Table";
import DefaultHeader from "../../components/layout/DefaultHeader";
import DownloadFacilitators from "../../components/layout/DownloadFacilitators";
import { useDownloadExcel } from "react-export-table-to-excel";


const PageHome: React.FC = () => {

    const [inProductionData, setInProductionData] = useState([]);
    const [awaitingShipmentData, setAwaitingShipment] = useState([]);
    const [awaitingReleaseData, setAwaitingRelease] = useState([]);
    const [dispatchedData, setDispatched] = useState([]);
    const [typeMessageInProduction, setTypeMessageInProduction] = useState(false);
    const [typeMessageAwaitingRelease, setTypeMessageAwaitingRelease] = useState(false);
    const [typeMessageAwaitingShipment, setTypeMessageAwaitingShipment] = useState(false);
    const [typeMessageDispatched, setTypeMessageDispatched] = useState(false);



    const columnsAwaitingRelease: Array<Object> = [
        {
            name: 'Nome Arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
  
        {
            name: 'Data Entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Qtd Cartões',
            selector: (row: any) => row.total_cartoes
        }
    ];

    const columnsInProduction: Array<Object> = [
        {
            name: 'Nome Arquivo',
            selector: (row: any) => row.nome_arquivo_proc,

        },
 
     
        {
            name: 'Data Entrada',
            selector: (row: any) => row.dt_processamento

        },
        {
            name: 'Qtd Cartões',
            selector: (row: any) => row.total_cartoes,
            sortable: true
        },

        {
            name: 'Etapa',
            selector: (row: any) => row.status,
            sortable: true
        },

    ];

    const columnsAwaitingShipment: Array<Object> = [
        {
            name: 'Nome Arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
    
        {
            name: 'Data Entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Qtd cartões',
            selector: (row: any) => row.total_cartoes
        },
    
        {
            name: 'Rastreio',
            selector: (row: any) => row.rastreio
        }

    ];

    const columnsDispatched: Array<Object> = [
        {
            name: 'Nome Arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
     
        {
            name: 'Data Entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Data Saida',
            selector: (row: any) => row.dt_expedicao
        },
        {
            name: 'Qtd Cartões',
            selector: (row: any) => row.total_cartoes
        }

    ];
    useEffect(() => {

        const HomePageRequests = async () => {
            await api.get('/awaiting-release')
                .then((data) => {
                    console.log("Dados recebidos da rota /awaiting-release:", data.data);
                    setAwaitingRelease(data.data);
                }).catch(() => {
                    setTypeMessageAwaitingRelease(true);
                });

            await api.post('/production')
                .then((data) => {
                    console.log('teste')
                    setInProductionData(data.data)

                }).catch(() => {
                    setTypeMessageInProduction(true)
                });

            await api.get('/awaiting-shipment')
                .then((data) => {
                    console.log("Dados recebidos da rota /awaiting-shipment:", data.data);
                    setAwaitingShipment(data.data);
                }).catch((error) => {
                    console.error("Erro ao obter dados da rota /awaiting-shipment:", error);
                    setTypeMessageAwaitingShipment(true);
                });

            await api.get('/dispatched')
                .then((data) => {
                    console.log("Dados recebidos da rota /dispatcheds:", data.data);
                    setDispatched(data.data);
                }).catch((error) => {
                    console.error("Erro ao obter dados da rota /dispatchedssssssssssss:", error);
                    setTypeMessageDispatched(true);
                });
        }

        HomePageRequests();

    }, []);

    
    const refExcel1: any = useRef();
    const { onDownload: onDownload1 } = useDownloadExcel({
        currentTableRef: refExcel1.current,
        filename: "Aguardando Liberação",
        sheet: "Aguardando Liberação"
    });
    
    const refExcel2: any = useRef();
    const { onDownload: onDownload2 } = useDownloadExcel({
        currentTableRef: refExcel2.current,
        filename: "Em Produção",
        sheet: "Em Produção"
    });
    
    const refExcel3: any = useRef();
    const { onDownload: onDownload3 } = useDownloadExcel({
        currentTableRef: refExcel3.current,
        filename: "Aguardando Expedição",
        sheet: "Aguardando Expedição"
    });
    
    const refExcel4: any = useRef();
    const { onDownload: onDownload4 } = useDownloadExcel({
        currentTableRef: refExcel4.current,
        filename: "Expedidos",
        sheet: "Expedidos"
    });
    




    return (
        <div className="container-page-home">

            <DefaultHeader />

            <div>
                <Table
                    data={Array.isArray(awaitingReleaseData) ? awaitingReleaseData[0] : []}
                    column={columnsAwaitingRelease}
                    titleTable="Aguardando liberação"
                    typeMessage={typeMessageAwaitingRelease}


                />
                <DownloadFacilitators excelClick={() => onDownload1()} printClick={() => window.print()} />

            </div>


            <div>
                <Table
                    data={Array.isArray(inProductionData) ? inProductionData : [0]}
                    column={columnsInProduction}
                    titleTable="Em produção"
                    typeMessage={typeMessageInProduction}
                />

                <DownloadFacilitators excelClick={() => onDownload2()} printClick={() => window.print()} />
            </div>
            <div>
                <Table
                    data={Array.isArray(awaitingShipmentData) ? awaitingShipmentData[0] : []}
                    column={columnsAwaitingShipment}
                    titleTable="Aguardando Expedição"
                    typeMessage={typeMessageAwaitingShipment}
                />
                <DownloadFacilitators excelClick={() => onDownload3()} printClick={() => window.print()} />
            </div>

            <div>
                <Table
                    data={Array.isArray(dispatchedData) ? dispatchedData[0] : []}
                    column={columnsDispatched}
                    titleTable="Expedidos"
                    typeMessage={typeMessageDispatched}
                   
                />
                <DownloadFacilitators excelClick={() => onDownload4()} printClick={() => window.print()} />
            </div>

            <div className="table-container-dowload">

                <div className="scroll-table-dowload">
                    <table ref={refExcel1}>

                        <tbody>

                            <tr>
                                <td>Nome Arquivo</td>
                                <td>Cod Produto</td>
                                <td>Desc Produto</td>
                                <td>Data Entrada</td>
                                <td>Qtd Cartões</td>
                                <td>Qtd</td>
                            </tr>


                            {
                                awaitingReleaseData.map((data: any) =>
                                    <tr key={data.id}>
                                        <td>{data.nome_arquivo_proc}</td>
                                        <td>{data.cod_produto}</td>
                                        <td>{data.desc_produto}</td>
                                        <td>{data.dt_processamento}</td>
                                        <td>{data.total_cartoes}</td>

                                    </tr>
                                )
                            }



                        </tbody>

                    </table>

                </div>

                <div className="scroll-table-dowload">
                    <table ref={refExcel2}>

                        <tbody>

                            <tr>
                                <td>Nome Arquivo</td>
                                <td>Cod Produto</td>
                                <td>Desc Produto</td>
                                <td>Data Entrada</td>
                                <td>Qtd Cartões</td>
                                <td>Empresa</td>
                                <td>Rastreio</td>
                                <td>Etapa</td>
                            </tr>


                            {
                                inProductionData.map((data: any) =>
                                    <tr key={data.id}>
                                        <td>{data.nome_arquivo_proc}</td>
                                        <td>{data.cod_produto}</td>
                                        <td>{data.desc_produto}</td>
                                        <td>{data.dt_processamento}</td>
                                        <td>{data.total_cartoes}</td>
                                        <td>{data.empresa}</td>
                                        <td>{data.rastreio}</td>
                                        <td>{data.status}</td>

                                    </tr>
                                )
                            }



                        </tbody>

                    </table>

                </div>

                <div className="scroll-table-dowload">
                    <table ref={refExcel3}>

                        <tbody>

                            <tr>
                                <td>Nome Arquivo</td>
                                <td>Cod Produto</td>
                                <td>Desc Produto</td>
                                <td>Data Entrada</td>
                                <td>Qtd Cartões</td>
                                <td>Empresa</td>
                                <td>Rastreio</td>
                            
                            </tr>


                            {
                               awaitingShipmentData.map((data: any) =>
                                    <tr key={data.id}>
                                        <td>{data.nome_arquivo_proc}</td>
                                        <td>{data.cod_produto}</td>
                                        <td>{data.desc_produto}</td>
                                        <td>{data.dt_processamento}</td>
                                        <td>{data.total_cartoes}</td>
                                        <td>{data.empresa}</td>
                                        <td>{data.rastreio}</td>
                                       

                                    </tr>
                                )
                            }



                        </tbody>

                    </table>

                </div>

                <div className="scroll-table-dowload">
                    <table ref={refExcel4}>

                        <tbody>

                            <tr>
                                <td>Nome Arquivo</td>
                                <td>Cod Produto</td>
                                <td>Desc Produto</td>
                                <td>Data Entrada</td>
                                <td>Data Saida</td>
                                <td>Qtd Cartões</td>
                                <td>Empresa</td>
                                <td>Rastreio</td>
                            
                            </tr>


                            {
                               dispatchedData.map((data: any) =>
                                    <tr key={data.id}>
                                        <td>{data.nome_arquivo_proc}</td>
                                        <td>{data.cod_produto}</td>
                                        <td>{data.desc_produto}</td>
                                        <td>{data.dt_processamento}</td>
                                        <td>{data.dt_expedicao}</td>
                                        <td>{data.total_cartoes}</td>
                                        <td>{data.empresa}</td>
                                        <td>{data.rastreio}</td>
                                       

                                    </tr>
                                )
                            }



                        </tbody>

                    </table>

                </div>

               

            </div>
        </div >
    )
}

export default PageHome;