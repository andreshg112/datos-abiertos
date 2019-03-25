<?php

namespace Andreshg112\DatosAbiertos\Datasets;

use allejo\Socrata\SoqlQuery;
use allejo\Socrata\SodaClient;
use allejo\Socrata\SodaDataset;

class Divipola
{
    const SOURCE_DOMAIN = 'datos.gov.co';

    const DATASET_IDENTIFIER = 'gdxc-w37w';

    /** @var SodaClient $sodaClient */
    protected $sodaClient;

    /** @var SodaDataset $sodaDataset */
    protected $sodaDataset;

    public function __construct()
    {
        $this->sodaClient = new SodaClient(self::SOURCE_DOMAIN, config('datos-abiertos.token'));

        $this->sodaDataset = new SodaDataset($this->sodaClient, self::DATASET_IDENTIFIER);
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

    /**
     * Consulta el listado de municipios de acuerdo a los parámetros.
     * Si no se especifican, por defecto trae todos.
     * Para saber cómo usar los filtros, consultar en el siguiente enlace:
     * https://github.com/allejo/PhpSoda/wiki/Simple-Filters
     *
     * @param array|string|\allejo\Socrata\SoqlQuery $filterOrSoqlQuery Los parámetros de la consulta.
     * @return array[]
     */
    public function getData($filterOrSoqlQuery = '')
    {
        $data = $this->sodaDataset->getData($filterOrSoqlQuery);

        return $data;
    }
}
