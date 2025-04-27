@php
  // ['target', 'make-prepend', 'make-append', 'title', 'description', 'files'];
  $makes = [
      ['command', null, 'Command', null, 'Artisan 命令', Arr::get($moduleConfig, 'commands', [])],
      ['component', null, null, null, '组件', $moduleConfig['components'] ?? []],
      ['component-view', null, null, null, '组件视图', $moduleConfig['component-views'] ?? []],
      ['controller', null, 'Controller', null, '控制器', $moduleConfig['controllers'] ?? []],
      ['event', null, 'Event', null, '事件类', $moduleConfig['events'] ?? []],
      ['factory', null, 'Factory', null, '模型工厂', $moduleConfig['factories'] ?? []],
      ['job', null, null, 'Job', '队列任务', $moduleConfig['jobs'] ?? []],
      ['listener', null, null, 'Listener', '事件处理', $moduleConfig['listeners'] ?? []],
      ['mail', null, null, 'Mail', '可邮寄类', $moduleConfig['mails'] ?? []],
      ['middleware', null, null, 'Middleware', '中间件', $moduleConfig['middleware'] ?? []],
      ['migration', 'create_', '_table', null, '数据库迁移', $moduleConfig['migrations'] ?? []],
      ['model', $moduleConfig['name'], null, 'Models', '模型实体', $moduleConfig['entities'] ?? []],
      ['notification', null, 'Notification', null, '消息通知', $moduleConfig['notifications'] ?? []],
      ['policy', null, 'Policy', null, '', $moduleConfig['policies'] ?? []],
      ['provider', null, 'Provider', null, '', $moduleConfig['providers'] ?? []],
      ['request', null, 'Request', null, '', $moduleConfig['requests'] ?? []],
      ['resource', null, null, null, '', $moduleConfig['resources'] ?? []],
      ['rule', null, 'Rule', null, '', $moduleConfig['rules'] ?? []],
      ['seed', $moduleConfig['name'], 'Seeder', 'Seeders', '数据填充', $moduleConfig['seeds'] ?? []],
      ['test', null, null, null, '', $moduleConfig['tests'] ?? []],
  ];
@endphp
{{-- @each('admin::components.config.module-make', [['target' => 'make-model']], 'attributes') --}}
@foreach ($makes as $make)
  <x-admin::config.module-make :props="$make"></x-admin::config.module-make>
@endforeach
