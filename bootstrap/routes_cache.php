<?php

return array (
  'GET' => 
  array (
    '/api1/data-user/{id}' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/{id}',
      'action' => 'getDataByIds',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
    ),
    '/api1/data-user/user' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/user',
      'action' => 'getData',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
    ),
    '/api1/data-user/mahasiswa' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/mahasiswa',
      'action' => 'getDataMahasiswa',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
    ),
    '/api1/data-user/{id}/{name}' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user/{id}/{name}',
      'action' => 'testConfilt',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
    ),
    '/api1/data-user' => 
    array (
      'middleware' => NULL,
      'method' => 'GET',
      'uri' => '/data-user',
      'action' => 'create',
      'controller' => '\\Jamkrindo\\Controllers\\CobaController',
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
    ),
  ),
);
