<?php

namespace Andreshg112\DatosAbiertos\Datasets;

/**
 * https://www.datos.gov.co/Mapas-Nacionales/DIVIPOLA-Codigos-municipios/gdxc-w37w.
 *
 * @method array|null getByCodMpio(string $value) Consulta los datos de un municipio por su código.
 */
class Divipola extends BaseDataset
{
    public function getColumns()
    {
        return [
            ['name' => 'cod_depto'],
            ['name' => 'cod_mpio', 'unique' => true],
            ['name' => 'dpto'],
            ['name' => 'nom_mpio'],
        ];
    }

    protected function getDatasetIdentifier()
    {
        return 'gdxc-w37w';
    }
}
