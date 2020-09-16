<?php return array (
  'facade/ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'jenssegers/agent' => 
  array (
    'providers' => 
    array (
      0 => 'Jenssegers\\Agent\\AgentServiceProvider',
    ),
    'aliases' => 
    array (
      'Agent' => 'Jenssegers\\Agent\\Facades\\Agent',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'oscarafdev/migrations-generator' => 
  array (
    'providers' => 
    array (
      0 => 'Way\\Generators\\GeneratorsServiceProvider',
      1 => 'OscarAFDev\\MigrationsGenerator\\MigrationsGeneratorServiceProvider',
    ),
  ),
  'overtrue/laravel-wechat' => 
  array (
    'providers' => 
    array (
      0 => 'Overtrue\\LaravelWeChat\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'EasyWeChat' => 'Overtrue\\LaravelWeChat\\Facade',
    ),
  ),
);