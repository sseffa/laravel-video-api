Laravel Video API
=================

[![Latest Stable Version](https://poser.pugx.org/sseffa/video-api/v/stable.png)](https://packagist.org/packages/sseffa/video-api)
[![Total Downloads](https://poser.pugx.org/sseffa/video-api/downloads.png)](https://packagist.org/packages/sseffa/video-api)
[![Build Status](https://travis-ci.org/sseffa/laravel-video-api.svg)](https://travis-ci.org/sseffa/laravel-video-api)

## Installation

### 1. Install with Composer

```bash
composer require "sseffa/video-api": "dev-master"
```

 Laravel  | video-api
:---------|:----------
 4.x.x    | 1.x
 5.x.x    | 2.x


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

[Youtube API Key](https://console.developers.google.com)


```php
<?php

Route::get('video/youtube/{id}', function ($id) {

    //$data = VideoApi::setType('youtube')->setKey('api-key')->getVideoDetail($id); // video detail
    $data = VideoApi::setType('youtube')->setKey('api-key')->getVideoList($id);     // video list

    var_dump($data);
});

Route::get('video/vimeo/{id}', function ($id) {

    //$data = VideoApi::setType('vimeo')->getVideoDetail($id);
    $data = VideoApi::setType('vimeo')->getVideoList($id);

    var_dump($data);
});

```

## Licence

[MIT license](http://opensource.org/licenses/MIT)
