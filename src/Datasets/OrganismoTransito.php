<?php

namespace Andreshg112\DatosAbiertos\Datasets;

/**
 * https://www.datos.gov.co/Transporte/ORGANISMO-DE-TR-NSITO/88yh-mmbj
 *
 * @method array|null getByCodDivipola(string $value) Consulta los datos de un organismo de tránsito por su código.
 */
class OrganismoTransito extends BaseDataset
{
    public function getColumns()
    {
        return [
            ['name' => 'abreviatura'],
            ['name' => 'categor_a'],
            ['name' => 'ciudad'],
            ['name' => 'cod_divipola', 'unique' => true],
            ['name' => 'departamento'],
            ['name' => 'estado'],
            ['name' => 'jurisdicci_n'],
            ['name' => 'organismo_de_tr_nsito'],
        ];
    }

    protected function getDatasetIdentifier()
    {
        return 'nnja-ngwf';
    }
}
