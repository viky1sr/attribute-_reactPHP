<?php

return array (
  'GET' => 
  array (
    '/api1/data-user/{id}/{name}' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/{id}/{name}',
      'action' => 'testConfilt',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
        'name' => 'string',
      ),
      'max_regex' => 2,
    ),
    '/api1/data-user/{id}' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/{id}',
      'action' => 'getDataByIds',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 1,
    ),
    '/api1/data-user/user' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/user',
      'action' => 'getData',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
      ),
      'max_regex' => 0,
    ),
    '/api1/data-user/mahasiswa' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/mahasiswa',
      'action' => 'getDataMahasiswa',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
      ),
      'max_regex' => 0,
    ),
    '/api1/data-user' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user',
      'action' => 'create',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/data-user/{id}' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/{id}',
      'action' => 'getDataById',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 1,
    ),
    '/api/data-user/genre' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/genre',
      'action' => 'get',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/data-user' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user',
      'action' => 'create',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/test1/data-user/{id}' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/{id}',
      'action' => 'getDataById',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController1',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 1,
    ),
    '/api/test1/data-user/genre' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/genre',
      'action' => 'get',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController1',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/test1/data-user' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user',
      'action' => 'create',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController1',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/test2/data-user/name' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/name',
      'action' => 'isData',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController2',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
      ),
      'max_regex' => 0,
    ),
    '/api/test2/data-user/{id}' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/{id}',
      'action' => 'getDataById',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController2',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 1,
    ),
    '/api/test2/data-user/genre' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/genre',
      'action' => 'get',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController2',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/test2/data-user' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user',
      'action' => 'create',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController2',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/test3/data-user/{name}' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/{name}',
      'action' => 'getDataByName',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController3',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'name' => 'string',
      ),
      'max_regex' => 1,
    ),
    '/api/test3/data-user/{id}' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/{id}',
      'action' => 'getDataById',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController3',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 1,
    ),
    '/api/test3/data-user/genre' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user/genre',
      'action' => 'get',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController3',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
    '/api/test3/data-user' => 
    array (
      'middleware' => 
      array (
        0 => 'jwt',
      ),
      'method' => 'GET',
      'uri' => '/data-user',
      'action' => 'create',
      'controller' => '\\Jamkrindo\\Controllers\\TestingController3',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 0,
    ),
  ),
  'POST' => 
  array (
    '/api1/data-user/{id}' => 
    array (
      'middleware' => NULL,
      'method' => 'POST',
      'uri' => '/data-user/{id}',
      'action' => 'update',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
      'parameter_types' => 
      array (
        'request' => 'Jamkrindo\\Lib\\App\\RequestBody',
        'id' => 'int',
      ),
      'max_regex' => 1,
    ),
  ),
);
