import React, { useState } from "react";

interface Column {
  header: string;
  accessor: string;
}

interface Props {
  columns: Column[];
  title: string;
  data: any[]; // Adicionando propriedade para os dados
}

const CustomTable: React.FC<Props> = ({ columns, title, data }) => {
  const [pageSize, setPageSize] = useState(20); // Tamanho padrão da página
  const [showAll, setShowAll] = useState(false); // Estado para rastrear se todos os dados devem ser exibidos

  const handlePageSizeChange = (size: number) => {
    setPageSize(size);
    setShowAll(size === data.length); // Se o tamanho da página for igual ao total de dados, mostra todos os dados
  };

  const renderData = showAll ? data : data.slice(0, pageSize); // Renderizar todos os dados ou apenas a página atual

  return (
    <div className="custom-table">
      <h2>{title}</h2>
      <div>
        <button onClick={() => handlePageSizeChange(20)}>20</button>
        <button onClick={() => handlePageSizeChange(40)}>40</button>
        <button onClick={() => handlePageSizeChange(data.length)}>Todos</button>
      </div>
      <table>
        <thead>
          <tr>
            {columns.map((column, index) => (
              <th key={index}>{column.header}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {renderData.map((item, index) => (
            <tr key={index}>
              {columns.map((column, columnIndex) => (
                <td key={columnIndex}>{item[column.accessor]}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default CustomTable;
