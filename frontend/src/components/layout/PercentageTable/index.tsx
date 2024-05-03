import { useState, useEffect } from "react";
import api from "../../../connectionAPI";

const PercentageTable: React.FC = () => {
    const [totalProduced, setTotalProduced] = useState<number>(0);
    const [totalWaste, setTotalWaste] = useState<number>(0);
    const [dispatched, setDispatched] = useState<number>(0);
    const [processados, setProcessados] = useState<number>(0);

    useEffect(() => {
        fetchWasteProducts();
    }, []);

    const fetchWasteProducts = async () => {
        try {
            const response = await api.post("/graph");
            const data = response.data[0];
            const { em_producao, rejeitos, expedidos, processados } = data;

            setTotalProduced(parseInt(em_producao));
            setTotalWaste(parseInt(rejeitos));
            setDispatched(parseInt(expedidos));   
            setProcessados(parseInt(processados));      
        } catch (error) {
            console.log(error);
        }
    };

    
    const totalProcessado = processados
    const percentageProcessed = (totalProcessado/totalProcessado)* 100;
    const percentageProduced = (totalProduced /totalProcessado ) * 100;
    const percentageWaste = (totalWaste / totalProcessado) * 100;
    
    const percentageDispatched = (dispatched/ totalProcessado)
    

   
    return (
        <div className="percentage-table">
           
            <table>
                <thead>
                    <tr>
                        <th>Referência</th>
                        <th>QTD</th>
                        <th>Porcentagem</th>
                    </tr>
                </thead>
                <tbody>
              
                    <tr>
                        <td>Cartões Processados</td>
                        <td>{totalProcessado}</td>
                        <td> {percentageProcessed.toFixed(2)}%</td>
                    </tr>
                 
                 
                    <tr>
                        <td>Cartões em Produção</td>
                        <td>{totalProduced}</td>
                        <td>{percentageProduced.toFixed(2)}%</td>
                    </tr>

                  
                    <tr>
                        <td>Rejeitos</td>
                        <td>{totalWaste}</td>
                        <td>{percentageWaste.toFixed(2)}%</td>
                    </tr>

                    <tr>
                        <td>Cartões Expedidos</td>
                        <td>{dispatched}</td>
                        <td>{percentageDispatched.toFixed(2)}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    );
};

export default PercentageTable;
