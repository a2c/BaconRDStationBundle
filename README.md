BaconRDStationBundle
===============

[![Codacy Badge](https://api.codacy.com/project/badge/grade/bd38325975e34a3a9474f2479b0c6f98)](https://www.codacy.com/app/adan-grg/BaconRDStationBundle)
[![Latest Stable Version](https://poser.pugx.org/baconmanager/core-bundle/v/stable)](https://packagist.org/packages/baconmanager/core-bundle)
[![License](https://poser.pugx.org/baconmanager/core-bundle/license)](https://packagist.org/packages/baconmanager/core-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c988b49c-f887-43c8-921e-bfeed9846034/mini.png)](https://insight.sensiolabs.com/projects/c988b49c-f887-43c8-921e-bfeed9846034)

Este bundle é responsável por gerar a integração com a API do RD Station

## Instalação

Para instalar o bundle basta rodar o seguinte comando abaixo:

```bash
$ composer require baconmanager/rd-station-bundles
```
Agora adicione os seguintes bundles no arquivo AppKernel.php:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    // ...
    new Bacon\Bundle\CoreBundle\BaconRDStationBundle(),
    // ...
}
```
No arquivo **app/config/config.yml** adicione as seguintes configurações:

```yaml
bacon_rd_station:
    api:
        private_token: ...
        token: ...
```

## Utilizando a api

### Cadastrando e alterando um lead

```php
<?php
// src/AppBundle/Controller/DefaultController.php
public function rdStationAction()
{
    $api = $this->container->get('bacon_rd_station.api');

    $return = $api->api('conversions','POST',array(
        'email' => 'teste@gmail.com',
        'nome'  => 'Lead'
    ));
}
```
