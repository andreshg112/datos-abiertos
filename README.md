# [Datos Abiertos de Colombia](https://www.datos.gov.co) para Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/andreshg112/datos-abiertos.svg?style=flat-square)](https://packagist.org/packages/andreshg112/datos-abiertos)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.com/andreshg112/datos-abiertos.svg?branch=master)](https://travis-ci.com/andreshg112/datos-abiertos)
[![StyleCI](https://styleci.io/repos/177488663/shield)](https://styleci.io/repos/177488663)
[![Quality Score](https://img.shields.io/scrutinizer/g/andreshg112/datos-abiertos.svg?style=flat-square)](https://scrutinizer-ci.com/g/andreshg112/datos-abiertos)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/andreshg112/datos-abiertos/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/andreshg112/datos-abiertos/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/andreshg112/datos-abiertos.svg?style=flat-square)](https://packagist.org/packages/andreshg112/datos-abiertos)

Este paquete encapsula las consultas a la API de [Datos Abiertos del Gobierno de Colombia](https://www.datos.gov.co).

## Recursos implementados

-   [ESTABLECIMIENTOS EDUCATIVOS DE PREESCOLAR, BÁSICA](https://www.datos.gov.co/Educaci-n/ESTABLECIMIENTOS-EDUCATIVOS-DE-PREESCOLAR-B-SICA/ea56-rtcx/data) (`\Andreshg112\DatosAbiertos\Facades\Colegios`).

-   [Códigos de la Divisón Político-Administrativa del país](https://www.datos.gov.co/Mapas-Nacionales/DIVIPOLA-Codigos-municipios/gdxc-w37w) (`\Andreshg112\DatosAbiertos\Facades\Divipola`).

-   [Organismos de Tránsito](https://www.datos.gov.co/Transporte/ORGANISMO-DE-TR-NSITO/88yh-mmbj) (`\Andreshg112\DatosAbiertos\Facades\OrganismosTransito`).

> Si deseas que desarrolle una consulta a otro recurso de datos.gov.co, puedes realizar la petición en los [Issues](../../issues).

## Requisitos

-   Laravel >= 5.5
-   PHP >= 7.1.x

> Si quieres soporte para una versión inferior a las especificadas, por favor deja la petición en los [Issues](../../issues) y veré qué puedo hacer.

## Instalación

Puedes instalar el paquete a través de composer:

```bash
composer require andreshg112/datos-abiertos
```

Este paquete usa [Laravel Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery) por lo que, si usas Laravel 5.5 o superior, no debes preocuparte agregar `\Andreshg112\DatosAbiertos\DatosAbiertosServiceProvider` al listado de `providers` en el archivo `config/app.php`.

## Uso

### Uso básico

Cada recurso hereda de `\Andreshg112\DatosAbiertos\Datasets\BaseDataset`, el cual tiene el método `getData($filterOrSoqlQuery = '')` que permite consultar todos los registros del recurso o [filtrar](#uso-de-filtros) de acuerdo a los parámetros.

Por ejemplo:

```php
use Andreshg112\DatosAbiertos\Facades\Divipola;

// Listado total de municipios:
$data = Divipola::getData();
```

### Uso de filtros

> En la [definición de la API de Divipola](https://dev.socrata.com/foundry/www.datos.gov.co/gdxc-w37w) puedes encontrar los detalles del recurso y el uso de filtros.

> Advertencia: La API de datos.gov.co distingue mayúsculas y minúsculas. Por lo tanto si buscas, por ejemplo, `nom_mpio=valledupar` no aparecerá porque debe tener la `V` mayúscula.

```php
use Andreshg112\DatosAbiertos\Facades\Divipola;

// Para filtrar por código de departamento puedes hacer cualquiera de las siguientes formas:

$filterOrSoqlQuery = 'cod_depto=20'; // esta

$filterOrSoqlQuery = ['cod_depto' => '20']; // o esta

$data = Divipola::getData($filterOrSoqlQuery);
```

> Este paquete usa [allejo/php-soda](https://github.com/allejo/PhpSoda) para realizar las peticiones a los recursos de datos.gov.co usando Socrata Open Data API (SODA), por lo tanto `$filterOrSoqlQuery` puede ser cualquiera de los parámetros aceptados por la función `\allejo\Socrata\SodaDataset::getData(filterOrSoqlQuery)`. Para usar filtros avanzados, dirígete a su [documentación](https://github.com/allejo/PhpSoda/wiki/Simple-Filters) (en inglés).

## Extender la funcionalidad

### Macroable

La clase padre `\Andreshg112\DatosAbiertos\Datasets\BaseDataset` de los recursos (datasets) usa el trait `\Spatie\Macroable\Macroable` de [spatie/macroable](https://github.com/spatie/macroable), por lo que puedes extender la funcionalidad de cada recurso de la siguiente manera:

```php
// En el archivo app/Providers/AppServiceProvider.php:

use Andreshg112\DatosAbiertos\Facades\OrganismosTransito;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        OrganismosTransito::macro('whereEstadoLimit', function($estado, $limit){
            $filter = [
                '$where' => "estado = '$estado'", // https://dev.socrata.com/docs/queries
                '$limit' => $limit, // 1, 2, 3, etc.
            ];

            return $this->getData($filter);
        });
    }
}

// Y luego, en cualquier otra parte:
$data = OrganismosTransito::whereEstadoLimit('ACTIVO', 3);
```

Para más información, dirígete a su [documentación](https://github.com/spatie/macroable).

### Crear tu propio recurso

Puedes crear tu propio dataset que herede de `\Andreshg112\DatosAbiertos\Datasets\BaseDataset` de la siguiente manera:

> Este recurso será implementado en el paquete, solo se coloca de ejemplo.

```php
<?php

use Andreshg112\DatosAbiertos\Datasets\BaseDataset;

namespace App\Datasets;

/**
 * https://www.datos.gov.co/Educaci-n/colegios/u3ch-n6ec
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
        // El código del recurso, que es la última parte de la URL sin el .json
        // https://www.datos.gov.co/resource/xax6-k7eu.json
        return 'xax6-k7eu';
    }

    protected function getUniqueColumn()
    {
        return 'codigoestablecimiento';
    }
}
```

> La API no acepta tildes, `ñ` o caracteres especiales en los nombres.

Luego, tendrás que hacer una [fachada](https://laravel.com/docs/5.5/facades) para la clase y está listo para usarse. Puede ser una [fachada en tiempo real](https://laravel.com/docs/5.5/facades#real-time-facades) colocando el namespace `Facades` antes del namespace de la clase, así:

```php
use Facades\App\Datasets\Colegios;
```

## Métodos de los recursos (datasets)

Todos los recursos permiten el [filtrado avanzado](https://dev.socrata.com/docs/queries) a través del método `getData($filterOrSoqlQuery)`, pero para búsquedas simples, se puede usar el método `where(string $column, $value)` de la siguiente manera:

```php
use Facades\App\Datasets\Colegios; // Fachada en tiempo real.

$data = Colegios::where('modelos_educativos', 'EDUCACIÓN TRADICIONAL');
```

Las columnas del recurso o dataset (ya sea incluido o personalizado), que se indican en `getColumns()`, permiten acceden dinámicamente a métodos de acuerdo con los nombres transformados en camelCase, y el prefijo `where` con la primera letra mayúscula por ejemplo:

```php
use Facades\App\Datasets\Colegios;
use Andreshg112\DatosAbiertos\Facades\Divipola;
use Andreshg112\DatosAbiertos\Facades\OrganismosTransito;

// nombredepartamento
Colegios::whereNombredepartamento('Cesar'); // d minúscula porque no tiene subguión.

// nom_mpio
Divipola::whereNomMpio('Valledupar'); // M mayúscula porque tiene subguión.

// categor_a
OrganismosTransito::whereCategorA('A'); // A mayúscula porque tiene un subguión antes.
```

Todos los métodos retornan un vector de registros (array de arrays). Si se desea consultar un solo registro a través de la columna con valor único, entonces se hace uso de la función `find($uniqueValue)`. Esto hace que el método solo retorne un solo registro (array) en vez de un vector de registros. Por ejemplo:

```php
use Andreshg112\DatosAbiertos\Facades\Colegios; // Esta es la implementación incluída.

$data = Colegios::find(147707000156);

// Es equivalente a:
$data = Colegios::whereCodigoestablecimiento(147707000156)[0] ?? null;

// y a:
$data = Colegios::where('codigoestablecimiento', 147707000156)[0] ?? null;

```

### Columnas de valor único:

-   Colegios: codigo_establecimiento
-   Divipola: cod_mpio
-   OrganismosTransito: cod_divipola

> Los nombres de las columnas están especificados en la definición de la API de cada recurso en la plataforma de [Datos Abiertos](https://www.datos.gov.co).

### Pruebas

```bash
composer test
```

### Registro de cambios

Por favor, mira el listado de [Versiones](../../releases) para obtener más información sobre lo que ha cambiado recientemente.

## Contribuir

Por favor, mira el archivo [CONTRIBUTING](CONTRIBUTING.md) (en inglés) para más detalles.

### Seguridad

Si descubres una vulnerabilidad o fallo relacionado con seguridad, te agradezco que por favor me escribas a andreshg112@gmail.com en vez de hacerlo en el registro de errores.

## Créditos

-   [Andrés Herrera García](https://github.com/andreshg112)
-   [All Contributors](../../contributors)

## Licencia

Licencia MIT. Por favor, mira el archivo [License File](LICENSE.md) (en inglés) para más información.

## Laravel Package Boilerplate

Este paquete fue generado usando [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
