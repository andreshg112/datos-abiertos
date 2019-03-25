<?php

namespace Andreshg112\DatosAbiertos\Datasets;

/**
 * https://www.datos.gov.co/Educaci-n/ESTABLECIMIENTOS-EDUCATIVOS-DE-PREESCOLAR-B-SICA/ea56-rtcx/data.
 */
class Colegios extends BaseDataset
{
    public function getColumns()
    {
        return [
            'a_o', // año.
            'calendario',
            'codigo_etc', // nombre_Rector
            'codigodepartamento', 'codigoestablecimiento',
            'codigomunicipio', 'correo_electronico', 'direccion', 'discapacidades', 'especialidad',
            'estrato_socio_economico', 'etnias', 'grados', 'idiomas', 'internado', 'jornada',
            'matricula_contratada', 'modelos', 'modelos_educativos', 'niveles', 'nombredepartamento',
            'nombreestablecimiento', 'nombremunicipio', 'numero_de_sedes', 'prestador_de_servicio',
            'propiedad_planta_fisica', 'resguardo', 'secretaria', 'telefono', 'tipo_establecimiento',
            'zona',
        ];
    }

    protected function getDatasetIdentifier()
    {
        return 'xax6-k7eu';
    }

    protected function getUniqueColumn()
    {
        return 'codigoestablecimiento';
    }
}
