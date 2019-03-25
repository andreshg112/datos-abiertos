<?php

namespace Andreshg112\DatosAbiertos\Datasets;

use Illuminate\Support\Str;
use allejo\Socrata\SodaClient;
use allejo\Socrata\SodaDataset;
use Spatie\Macroable\Macroable;

abstract class BaseDataset
{
    use Macroable;

    const SOURCE_DOMAIN = 'datos.gov.co';

    /** @var SodaClient $sodaClient */
    protected $sodaClient;

    /** @var SodaDataset $sodaDataset */
    protected $sodaDataset;

    #region Funciones mágicas

    public function __construct()
    {
        $this->sodaClient = new SodaClient(self::SOURCE_DOMAIN, config('datos-abiertos.token'));

        $this->sodaDataset = new SodaDataset($this->sodaClient, $this->getDatasetIdentifier());

        $this->addMacroMethods();
    }

    #endregion

    #region Funciones abstractas

    /**
     * Retorna las columnas del dataset (recurso).
     *
     * @return string[]
     */
    abstract public function getColumns();

    /**
     * Retorna el identificador del dataset (recurso).
     *
     * @return string
     */
    abstract protected function getDatasetIdentifier();

    /**
     * Retorna la columna cuyo valor es único dentro del recurso (dataset).
     *
     * @return string
     */
    abstract protected function getUniqueColumn();

    #endregion

    #region Funciones

    /**
     * Agrega métodos dinámicos para consultar un dataset (recurso) por cada columna que tenga.
     *
     * @return void
     */
    private function addMacroMethods()
    {
        $columns = $this->getColumns();

        foreach ($columns as $column) {
            static::macro(
                'where' . ucfirst(Str::camel($column)),
                function ($value) use ($column) {
                    return $this->getData([$column  => $value]);
                }
            );
        }
    }

    /**
     * Undocumented function.
     *
     * @param int|string $uniqueValue
     * @return array
     */
    public function find($uniqueValue)
    {
        $data = $this->where($this->getUniqueColumn(), $uniqueValue);

        return $data[0] ?? null;
    }

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

    /**
     * Consulta registros del recurso por el valor de una columna.
     *
     * @param string $column
     * @param int|string $value
     * @return array[]
     */
    public function where(string $column, $value)
    {
        return $this->getData([$column => $value]);
    }

    #endregion
}
