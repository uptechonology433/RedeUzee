import React, { useEffect, useState } from "react";
import api from "../../connectionAPI";
import Table from "../../components/shared/Table";
import DefaultHeader from "../../components/layout/DefaultHeader";
import Select from "../../components/shared/Select";



const PageHome: React.FC = () => {
    const [inProductionData, setInProductionData] = useState([]);
    const [awaitingReleaseData, setAwaitingRelease] = useState([]);
    const [typeMessageInProduction, setTypeMessageInProduction] = useState(false);
    const [typeMessageAwaitingRelease, setTypeMessageAwaitingRelease] = useState(false);
    const [formValues, setFormValues] = useState({ Type: "tarja" });


    const handleChange = (e: any) => {
        const selectedType = e.target.value;
        setFormValues({
            ...formValues,
            [e.target.name]: selectedType,
        });
        setColumnsInProduction(getColumnsByType(selectedType));
       
    };


    const getColumnsByType = (type: string) => {
        switch (type) {
            case "tarja":
                return [
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
                        name: 'Data Pros',
                        selector: (row: any) => row.dt_processamento
                    },
                    {
                        name: 'Data op',
                        selector: (row: any) => row.dt_expedicao
                    },
                    {
                        name: 'Quantidade de cartões',
                        selector: (row: any) => row.total_cartoes,
                        sortable: true
                    },
                ];
            case "chip":
                return [
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
                        name: 'Data Pros',
                        selector: (row: any) => row.dt_processamento
                    },
                       {
                        name: 'Quantidade de cartões',
                        selector: (row: any) => row.rastreio,
                        sortable: true
                    },
                    {
                        name: 'Rastreio',
                        selector: (row: any) => row.total_cartoes,
                        sortable: true
                    },
                ];
            case "elo":
                return [
                    // ... colunas específicas para "elo"
                ];
            default:
                return [];

        }
    };

    const [columnsInProduction, setColumnsInProduction] = useState(getColumnsByType("tarja"));

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
            name: 'Data de liberação',
            selector: (row: any) => row.dt_expedicao
        }
    ];

    useEffect(() => {

        const HomePageRequests = async () => {

            await api.post('/production', { tipo: formValues.Type })
            .then((data) => {
                setInProductionData(data.data)
            }).catch(() => {
                setTypeMessageInProduction(true)
            });

        await api.get('/awaiting-release')
            .then((data) => {
                if(formValues.Type === "tarja"){
                    setAwaitingRelease(data.data[1])    
                }else{
                    setAwaitingRelease(data.data[0]) 
                }
                 
            }).catch(() => {
                setTypeMessageAwaitingRelease(true)
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
                data={Array.isArray(inProductionData) ? inProductionData : []}
                column={columnsInProduction}
                titleTable="Em produção"
                typeMessage={typeMessageInProduction}
            />
            <Table
                data={Array.isArray(awaitingReleaseData) ? awaitingReleaseData : []}
                column={columnsAwaitingRelease}
                titleTable="Aguardando liberação"
                typeMessage={typeMessageAwaitingRelease}
            />
        </div >
    )
}

export default PageHome;