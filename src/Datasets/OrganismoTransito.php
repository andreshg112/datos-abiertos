<?php

namespace Andreshg112\DatosAbiertos\Datasets;

class OrganismoTransito extends BaseDataset
{
    protected function getDatasetIdentifier()
    {
        return 'nnja-ngwf';
    }

    /**
     * Consulta los datos de un organismo de tránsito por su código.
     *
     * @param string $codMpio
     * @return array|null
     */
    public function getByCodDivipola(string $codMpio)
    {
        $data = $this->getData(['cod_divipola' => $codMpio]);
        return $data[0] ?? null;
    }
}
