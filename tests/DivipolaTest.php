<?php

namespace Andreshg112\DatosAbiertos\Tests;

use Orchestra\Testbench\TestCase;
use Andreshg112\DatosAbiertos\Facades\Divipola;
use Andreshg112\DatosAbiertos\DatosAbiertosServiceProvider;

class DivipolaTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [DatosAbiertosServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Divipola' => Divipola::class,
        ];
    }

    /** @test */
    public function it_returns_a_list_of_municipalities()
    {
        $mockedResponse = [
            [
                'cod_depto' => '20',
                'cod_mpio' => '20011',
                'dpto' => 'Cesar',
                'nom_mpio' => 'Aguachica',
            ],
            [
                'cod_depto' => '20',
                'cod_mpio' => '20032',
                'dpto' => 'Cesar',
                'nom_mpio' => 'Astrea',
            ],
        ];

        Divipola::shouldReceive('getData')
            ->once()
            ->andReturn($mockedResponse);

        $data = Divipola::getData();

        $this->assertArraySubset($mockedResponse, $data);
    }

    /** @test */
    public function it_returns_one_municipality_by_code()
    {
        $codMpio = '20001';

        $mockedResponse = [
            'cod_depto' => '20',
            'cod_mpio' => $codMpio,
            'dpto' => 'Cesar',
            'nom_mpio' => 'Valledupar',
        ];

        Divipola::shouldReceive('find')
            ->with($codMpio)
            ->once()
            ->andReturn($mockedResponse);

        $data = Divipola::find($codMpio);

        $this->assertArraySubset($mockedResponse, $data);
    }
}
