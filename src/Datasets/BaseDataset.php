<?php

namespace Andreshg112\DatosAbiertos\Datasets;

use allejo\Socrata\SodaClient;
use allejo\Socrata\SodaDataset;

abstract class BaseDataset
{
    const SOURCE_DOMAIN = 'datos.gov.co';

    /** @var SodaClient $sodaClient */
    protected $sodaClient;

    /** @var SodaDataset $sodaDataset */
    protected $sodaDataset;

    public function __construct()
    {
        $this->sodaClient = new SodaClient(self::SOURCE_DOMAIN, config('datos-abiertos.token'));

        $this->sodaDataset = new SodaDataset($this->sodaClient, $this->getDatasetIdentifier());
    }

    /**
     * Retorna el identificador del dataset o del recurso.
     *
     * @return string
     */
    abstract protected function getDatasetIdentifier();

    /**
     * Consulta el listado del recurso de acuerdo a los parámetros.
     * Si no se especifican, por defecto trae todos.
     * Para saber cómo usar los filtros, consultar en el siguiente enlace:
     * https://github.com/allejo/PhpSoda/wiki/Simple-Filters.
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
