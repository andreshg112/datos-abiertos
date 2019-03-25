<?php

namespace Andreshg112\DatosAbiertos\Datasets;

/**
 * https://www.datos.gov.co/Transporte/ORGANISMO-DE-TR-NSITO/88yh-mmbj.
 *
 * @method array|null whereCodDivipola(string $value) Consulta los datos de un organismo de tránsito por su código.
 */
class OrganismosTransito extends BaseDataset
{
    public function getColumns()
    {
        return [
            'abreviatura', 'categor_a', 'ciudad', 'cod_divipola', 'departamento', 'estado',
            'jurisdicci_n', 'organismo_de_tr_nsito',
        ];
    }

    protected function getDatasetIdentifier()
    {
        return 'nnja-ngwf';
    }

    protected function getUniqueColumn()
    {
        return 'cod_divipola';
    }
}
