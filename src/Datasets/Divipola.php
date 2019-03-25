<?php

namespace Andreshg112\DatosAbiertos\Datasets;

/**
 * https://www.datos.gov.co/Mapas-Nacionales/DIVIPOLA-Codigos-municipios/gdxc-w37w.
 *
 * @method array|null whereCodMpio(string $value) Consulta los datos de un municipio por su código.
 */
class Divipola extends BaseDataset
{
    public function getColumns()
    {
        return ['cod_depto', 'cod_mpio', 'dpto', 'nom_mpio'];
    }

    protected function getDatasetIdentifier()
    {
        return 'gdxc-w37w';
    }

    protected function getUniqueColumn()
    {
        return 'cod_mpio';
    }
}
