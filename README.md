Laravel Video API
=================

[![Latest Stable Version](https://poser.pugx.org/sseffa/video-api/v/stable.png)](https://packagist.org/packages/sseffa/video-api)
[![Total Downloads](https://poser.pugx.org/sseffa/video-api/downloads.png)](https://packagist.org/packages/sseffa/video-api)
[![Coverage Status](https://coveralls.io/repos/sseffa/video-api/badge.png)](https://coveralls.io/r/sseffa/video-api)


## Installation

### 1. Install with Composer

```bash
composer require "sseffa/video-api": "dev-master"
```

### 2. Add to `app/config/app.php`

```php
    'providers' => array(
        // ...
        'Sseffa\VideoApi\VideoApiServiceProvider',
    ),
```

And:

```php
    'aliases' => array(
        // ...
        'VideoApi'          => 'Sseffa\VideoApi\Facades\VideoApi',
    ),
```

## Usage


```php
<?php

Route::get('video/youtube/{id}', function ($id) {

    $videoChannel = VideoApi::getInstance('youtube'); // get instance
    $videoChannel->setId($id); // set id

    //$videoList = $videoChannel->getVideoList(); // list
    $videoList = $videoChannel->getVideoDetail(); // detail

    var_dump($videoList);
});

Route::get('video/vimeo/{id}', function ($id) {

    $videoChannel = VideoApi::getInstance('vimeo'); // get instance
    $videoChannel->setId($id);

    //$videoList = $videoChannel->getVideoDetail();
    $videoList = $videoChannel->getVideoList();

    var_dump($videoList);
});

```

## Licence

[MIT license](http://opensource.org/licenses/MIT)
