import React, { useEffect, useState } from "react";
import api from "../../connectionAPI";
import Table from "../../components/shared/Table";
import DefaultHeader from "../../components/layout/DefaultHeader";
import Select from "../../components/shared/Select";



const PageHome: React.FC = () => {
    const [inProductionData, setInProductionData] = useState([]);
    const [awaitingReleaseData, setAwaitingRelease] = useState([]);
    const [awaitingShipmentData, setAwaitingShipment] = useState([]);
    const [dispatchedData, setDispatched] = useState([]);
    const [typeMessageInProduction, setTypeMessageInProduction] = useState(false);
    const [typeMessageAwaitingRelease, setTypeMessageAwaitingRelease] = useState(false);
    const [typeMessageAwaitingShipment, setTypeMessageAwaitingShipment] = useState(false);
    const [typeMessageDispatched, setTypeMessageDispatched] = useState(false);
    const [formValues, setFormValues] = useState({ Type: "tarja" });


    const handleChange = (e: any) => {
        setFormValues({
            ...formValues,
            [e.target.name]: e.target.value
        })
    }


    const columnsInProduction: Array<Object> = [
        {
            name: 'Codigo do produto',
            selector: (row: any) => row.cod_produto,
            sortable: true
        },
        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc,

        },
        {
            name: 'Desc do Produto',
            selector: (row: any) => row.desc_produto,


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
    ];


  

    const columnsAwaitingRelease: Array<Object> = [
        {
            name: 'Codigo do produto',
            selector: (row: any) => row.cod_produto,
            sortable: true
        },
        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
        {
            name: 'Desc do Produto',
            selector: (row: any) => row.desc_produto

        },
        {
            name: 'Data de entrada',
            selector: (row: any) => row.dt_processamento
        },
        {
            name: 'Qtd cartões',
            selector: (row: any) => row.total_cartoes
        }
    ];

    const columnsAwaitingShipment: Array<Object> = [
        {
            name: 'Codigo do produto',
            selector: (row: any) => row.cod_produto,
            sortable: true
        },
        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
        {
            name: 'Desc do Produto',
            selector: (row: any) => row.desc_produto

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
            name : 'Empresa',
            selector: (row: any) => row.empresa
        },
        {
            name : 'Rastreio',
            selector: (row: any) => row.rastreio
        }
       
    ];

    const columnsDispatched: Array<Object> = [
        {
            name: 'Codigo do produto',
            selector: (row: any) => row.cod_produto,
            sortable: true
        },
        {
            name: 'Nome do arquivo',
            selector: (row: any) => row.nome_arquivo_proc

        },
        {
            name: 'Desc do Produto',
            selector: (row: any) => row.desc_produto

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
        {
            name : 'Empresa',
            selector: (row: any) => row.empresa
        },
        {
            name : 'Rastreio',
            selector: (row: any) => row.rastreio
        }
       
    ];

    useEffect(() => {

        const HomePageRequests = async () => {

            
            await api.get('/awaiting-release')
                .then((data) => {
                    if (formValues.Type === "tarja") {
                        setAwaitingRelease(data.data[1]);
                    } else if (formValues.Type === "chip") {
                        setAwaitingRelease(data.data[0]);
                    } else {
                        setAwaitingRelease(data.data[2]);
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
                    if (formValues.Type === "tarja") {
                        setAwaitingShipment(data.data[1]);
                    } else if (formValues.Type === "chip") {
                        setAwaitingShipment(data.data[0]);
                    } else {
                        setAwaitingShipment(data.data[2]);
                    }
                })
                .catch(() => {
                    setTypeMessageAwaitingShipment(true);
                });

                await api.get('/dispatched')
                .then((data) => {
                    if (formValues.Type === "tarja") {
                        setDispatched(data.data[1]);
                    } else if (formValues.Type === "chip") {
                        setDispatched(data.data[0]);
                    } else {
                        setDispatched(data.data[2]);
                    }
                })
                .catch(() => {
                    setTypeMessageDispatched(true);
                });
        }

        HomePageRequests()

    }, [formValues]);










    return (
        <div className="container-page-home">

            <DefaultHeader />

            <Select info={"Selecione o tipo de cartão:"} name="Type" onChange={handleChange}>

                <option value="tarja" selected>Tarja</option>

                <option value="chip">Chip</option>

                <option value="elo">Elo</option>

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
                titleTable="Aguardando expedição"
                typeMessage={typeMessageAwaitingShipment} />

            <Table
                data={Array.isArray(dispatchedData) ? dispatchedData : []}
                column={columnsDispatched}
                titleTable="Expedidos"
                typeMessage={typeMessageDispatched} />
        </div >
    )
}

export default PageHome;