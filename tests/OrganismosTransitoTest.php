<?php

namespace Andreshg112\DatosAbiertos\Tests;

use Orchestra\Testbench\TestCase;
use Andreshg112\DatosAbiertos\Facades\OrganismosTransito;
use Andreshg112\DatosAbiertos\DatosAbiertosServiceProvider;

class OrganismosTransitoTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [DatosAbiertosServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'OrganismosTransito' => OrganismosTransito::class,
        ];
    }

    /** @test */
    public function it_returns_a_list_of_organisms()
    {
        $mockedResponse = [
            [
                'abreviatura' => 'INST MCPAL TTOyTTE VALLEDUPAR',
                'categor_a' => 'A',
                'ciudad' => 'VALLEDUPAR',
                'cod_divipola' => '20001000',
                'departamento' => 'CESAR',
                'estado' => 'ACTIVO',
                'jurisdicci_n' => 'MUNICIPAL',
                'organismo_de_tr_nsito' => 'INST MCPAL TTOyTTE VALLEDUPAR',
            ],
        ];

        OrganismosTransito::shouldReceive('getData')
            ->once()
            ->andReturn($mockedResponse);

        $data = OrganismosTransito::getData();

        $this->assertArraySubset($mockedResponse, $data);
    }

    /** @test */
    public function it_returns_one_organism_by_cod_divipola()
    {
        $codDivipola = '20001000';

        $mockedResponse = [
            'abreviatura' => 'INST MCPAL TTOyTTE VALLEDUPAR',
            'categor_a' => 'A',
            'ciudad' => 'VALLEDUPAR',
            'cod_divipola' => '20001000',
            'departamento' => 'CESAR',
            'estado' => 'ACTIVO',
            'jurisdicci_n' => 'MUNICIPAL',
            'organismo_de_tr_nsito' => 'INST MCPAL TTOyTTE VALLEDUPAR',
        ];

        OrganismosTransito::shouldReceive('find')
            ->with($codDivipola)
            ->once()
            ->andReturn($mockedResponse);

        $data = OrganismosTransito::find($codDivipola);

        $this->assertArraySubset($mockedResponse, $data);
    }
}
