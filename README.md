# QueryAPI
Query Information from other servers with ease

| Phar | View Count |
| :---: | :---: |
 [![Download](https://img.shields.io/badge/download-latest-blue.svg)](https://poggit.pmmp.io/ci/PotatoeTrainYT/QueryAPI/~) | [![View Count](http://hits.dwyl.io/PotatoeTrainYT/QueryAPI.svg)](http://hits.dwyl.io/PotatoeTrainYT/QueryAPI) |

## Features
- [x] Query Server MOTD
- [x] Query Server Version
- [x] Query Server Player Count
- [x] Query Server Max Players

## How to use
```php
<?php

declare(strict_types=1);

namespace QueryExample;

use pocketmine\plugin\PluginBase;

use QueryAPI\Query;

class Main extends PluginBase {

    public function onEnable() : void {
        $ip = "example.com";
        $port = 19132;
        $query = Query::queryServer($ip, $port);
        $this->getLogger()->info($query["motd"], $query["version"], $query["online"], $query["max"]);
    }
}
```
