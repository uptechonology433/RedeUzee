import React, { useEffect, useState } from "react";
import api from "../../connectionAPI";
import Table from "../../components/shared/Table";
import DefaultHeader from "../../components/layout/DefaultHeader";
import Select from "../../components/shared/Select";
import Chart from "chart.js/auto";
import PercentageTable from "../../components/layout/PercentageTable";
import CustomTable from "../../components/shared/CustomTable"; // Importe o CustomTable



const PageHome: React.FC = () => {
    const [inProductionData, setInProductionData] = useState([]);
    const [awaitingReleaseData, setAwaitingRelease] = useState([]);
    const [awaitingShipmentData, setAwaitingShipment] = useState([]);
    const [dispatchedData, setDispatched] = useState([]);
    const [typeMessageInProduction, setTypeMessageInProduction] = useState(false);
    const [typeMessageAwaitingRelease, setTypeMessageAwaitingRelease] = useState(false);
    const [typeMessageAwaitingShipment, setTypeMessageAwaitingShipment] = useState(false);
    const [typeMessageDispatched, setTypeMessageDispatched] = useState(false);
    const [formValues, setFormValues] = useState({ Type: "redeuze" });
    const [rupturesData, setRupturesData] = useState([]);
    const [pieChart, setPieChart] = useState<Chart<'pie' | 'doughnut', any[], string> | null>(null);

    useEffect(() => {
        fetchWasteProducts();
    }, []);


    const fetchWasteProducts = async () => {
        try {
            const response = await api.post("/graph");
            const data = response.data[0];
            const { rejeitos, processados, expedidos, em_producao } = data;


            const ctx = document.getElementById("wasteChart") as HTMLCanvasElement;

            if (ctx) {
                if (pieChart) {
                    pieChart.destroy();
                }

                const chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Produzidos', 'Quantidade de Rejeitos', 'Em Produção',],
                        datasets: [{
                            label: 'Quantidade',
                            data: [expedidos, rejeitos, em_producao],
                            backgroundColor: [

                                'rgba(43, 23, 194, 0.5)', // Cor para "Total Produzido"
                                'rgba(8, 8, 8, 0.5)',
                                'rgba(227, 119, 18, 0.5)', // Cor para "Quantidade de Rejeitos"

                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Performance Mensal',
                                font: {
                                    size: 18
                                }
                            },
                            legend: {
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                        }
                    }
                });
                setPieChart(chart);
            }
        } catch (error) {
            console.log(error);
        }
    };


    const handleChange = (e: any) => {
        setFormValues({
            ...formValues,
            [e.target.name]: e.target.value
        })
    }



    const columnsAwaitingRelease: Array<Object> = [

        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
        {
            name: 'Data de entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Qtd cartões',
            selector: (row: any) => row.total_cartoes
        },
        {
            name: 'Observação',
            selector: (row: any) => row.observacao
        }
    ];


    const columnsInProduction: Array<Object> = [

        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc,

        },

        {
            name: 'Data Pros',
            selector: (row: any) => row.dt_processamento

        },
        {
            name: 'Quantidade de cartões',
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
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },

        {
            name: 'Data de entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Qtd cartões',
            selector: (row: any) => row.total_cartoes
        },

    ];

    const columnsDispatched: Array<Object> = [

        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc
        },
        {
            name: 'Data de entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Data de saida',
            selector: (row: any) => row.dt_expedicao
        },
        {
            name: 'Qtd cartões',
            selector: (row: any) => row.total_cartoes
        },

    ];


    const columnsRuptures: Array<Object> = [
        {
            name: 'Codigo do produto',
            selector: (row: any) => row["COD PROD"],
            sortable: true
        },
        {
            name: 'Produto',
            selector: (row: any) => row.PRODUTO,
            sortable: true
        },
        {
            name: 'Data',
            selector: (row: any) => row.dt_op,
            sortable: true
        },
        {
            name: 'Estoque',
            selector: (row: any) => row["QTD ESTQ"],
            sortable: true
        },
        {
            name: 'Qtd Cartões',
            selector: (row: any) => row["QTD ARQ"],
            sortable: true
        },
        {
            name: 'Diferença',
            selector: (row: any) => row.DIFERENÇA,
            sortable: true
        },
        {
            name: 'Descrição',
            selector: (row: any) => row.observacao,
            sortable: true
        }
    ];

    useEffect(() => {

        const HomePageRequests = async () => {


            await api.get('/awaiting-release')
                .then((data) => {
                    if (formValues.Type === "redeuze") {
                        setAwaitingRelease(data.data[0]);
                        console.log(data.data[0])
                    }
                })
                .catch(() => {
                    setTypeMessageAwaitingRelease(true);
                });

            await api.post('/production', { tipo: formValues.Type })
                .then((data) => {
                    setInProductionData(data.data)
                }).catch(() => {
                    setTypeMessageInProduction(true)
                });

            await api.get('/awaiting-shipment')
                .then((data) => {

                    if (formValues.Type === "redeuze") {
                        setAwaitingShipment(data.data[0]);
                    }
                })
                .catch(() => {
                    setTypeMessageAwaitingShipment(true);
                });

            await api.get('/dispatched')
                .then((data) => {
                    if (formValues.Type === "redeuze") {
                        setDispatched(data.data[0]);
                    }
                })
                .catch(() => {
                    setTypeMessageDispatched(true);
                });
        }

        HomePageRequests()

    }, [formValues]);



    useEffect(() => {
        fetchRupturesProducts();
    }, []);

    const fetchRupturesProducts = async () => {
        try {
            const response = await api.post("/ruptures-products");
            setRupturesData(response.data);
        } catch (error) {
            console.log(error);

        }
    };








    return (
        <div className="container-page-home">

            <DefaultHeader />

            <Select info={"Selecione o tipo de cartão:"} name="Type" onChange={handleChange}>

                <option value="redeuze">Rede Uze</option>



            </Select>




            <Table
                data={Array.isArray(awaitingReleaseData) ? awaitingReleaseData : []}
                column={columnsAwaitingRelease}
                titleTable="Aguardando liberação"
                typeMessage={typeMessageAwaitingRelease}
            />


            <Table
                data={Array.isArray(inProductionData) ? inProductionData : []}
                column={columnsInProduction}
                titleTable="Em produção"
                typeMessage={typeMessageInProduction}


            />

            <Table
                data={Array.isArray(awaitingShipmentData) ? awaitingShipmentData : []}
                column={columnsAwaitingShipment}
                titleTable="Aguardando Expedição"
                typeMessage={typeMessageAwaitingShipment} />

            <Table
                data={Array.isArray(dispatchedData) ? dispatchedData : []}
                column={columnsDispatched}
                titleTable="Expedidos"
                typeMessage={typeMessageDispatched} />

            <Table
                data={rupturesData}
                column={columnsRuptures}
                titleTable="Rupturas"
            />
            <div className="graph">
                <PercentageTable />
                <div className="chart-container">
                    <canvas id="wasteChart" width="600" height="400"></canvas>
                </div>

            </div>


        </div >
    )
}

export default PageHome;