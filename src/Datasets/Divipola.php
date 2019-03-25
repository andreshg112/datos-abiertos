<?php

namespace Andreshg112\DatosAbiertos\Datasets;

class Divipola extends BaseDataset
{
    protected function getDatasetIdentifier()
    {
        return 'gdxc-w37w';
    }

    /**
     * Consulta los datos de un municipio por su código.
     *
     * @param string $codMpio
     * @return array|null
     */
    public function getByCodMpio(string $codMpio)
    {
        $data = $this->getData(['cod_mpio' => $codMpio]);

        return $data[0] ?? null;
    }
}
