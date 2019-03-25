<?php

namespace Andreshg112\DatosAbiertos\Tests;

use Orchestra\Testbench\TestCase;
use Andreshg112\DatosAbiertos\Facades\Colegios;
use Andreshg112\DatosAbiertos\DatosAbiertosServiceProvider;

class ColegiosTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [DatosAbiertosServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Colegios' => Colegios::class,
        ];
    }

    /** @test */
    public function it_returns_a_list_of_municipalities()
    {
        $mockedResponse = [
            [
                'a_o' => '2016',
                'calendario' => 'A',
                'codigo_etc' => 'LUZ MARINA GARZON ATEHORTUA',
                'codigodepartamento' => '5',
                'codigoestablecimiento' => '305001006831',
                'codigomunicipio' => '5001',
                'correo_electronico' => 'musicalinstituto@gmail.com',
                'direccion' => 'IND CR 32 N. 6SUR - 191',
                'discapacidades' => 'SÍNDROME DE DOWN',
                'especialidad' => 'ACADÉMICA',
                'grados' => '-2,-1,0,1,2,3,4,5,6,7,8,9,10,11',
                'jornada' => 'COMPLETA',
                'matricula_contratada' => 'NO',
                'modelos' => 'NO APLICA',
                'modelos_educativos' => 'EDUCACIÓN TRADICIONAL',
                'niveles' => 'PREESCOLAR,MEDIA,BÁSICA SECUNDARIA,BÁSICA PRIMARIA',
                'nombredepartamento' => 'ANTIOQUIA',
                'nombreestablecimiento' => 'INST MUSICAL DIEGO ECHAVARRIA',
                'nombremunicipio' => 'MEDELLÍN',
                'numero_de_sedes' => '1',
                'prestador_de_servicio' => 'PERSONA NATURAL',
                'propiedad_planta_fisica' => 'PERSONA NATURAL',
                'resguardo' => 'NO APLICA',
                'secretaria' => 'MEDELLIN',
                'telefono' => '3115241',
                'tipo_establecimiento' => 'INSTITUCION EDUCATIVA',
                'zona' => 'URBANA',
            ],
        ];

        Colegios::shouldReceive('getData')
            ->once()
            ->andReturn($mockedResponse);

        $data = Colegios::getData();

        $this->assertArraySubset($mockedResponse, $data);
    }

    /** @test */
    public function it_returns_one_municipality_by_code()
    {
        $codMpio = '20001';

        $mockedResponse = [
            'a_o' => '2016',
            'calendario' => 'A',
            'codigo_etc' => 'LUZ MARINA GARZON ATEHORTUA',
            'codigodepartamento' => '5',
            'codigoestablecimiento' => '305001006831',
            'codigomunicipio' => '5001',
            'correo_electronico' => 'musicalinstituto@gmail.com',
            'direccion' => 'IND CR 32 N. 6SUR - 191',
            'discapacidades' => 'SÍNDROME DE DOWN',
            'especialidad' => 'ACADÉMICA',
            'grados' => '-2,-1,0,1,2,3,4,5,6,7,8,9,10,11',
            'jornada' => 'COMPLETA',
            'matricula_contratada' => 'NO',
            'modelos' => 'NO APLICA',
            'modelos_educativos' => 'EDUCACIÓN TRADICIONAL',
            'niveles' => 'PREESCOLAR,MEDIA,BÁSICA SECUNDARIA,BÁSICA PRIMARIA',
            'nombredepartamento' => 'ANTIOQUIA',
            'nombreestablecimiento' => 'INST MUSICAL DIEGO ECHAVARRIA',
            'nombremunicipio' => 'MEDELLÍN',
            'numero_de_sedes' => '1',
            'prestador_de_servicio' => 'PERSONA NATURAL',
            'propiedad_planta_fisica' => 'PERSONA NATURAL',
            'resguardo' => 'NO APLICA',
            'secretaria' => 'MEDELLIN',
            'telefono' => '3115241',
            'tipo_establecimiento' => 'INSTITUCION EDUCATIVA',
            'zona' => 'URBANA',
        ];

        Colegios::shouldReceive('find')
            ->with($codMpio)
            ->once()
            ->andReturn($mockedResponse);

        $data = Colegios::find($codMpio);

        $this->assertArraySubset($mockedResponse, $data);
    }
}
