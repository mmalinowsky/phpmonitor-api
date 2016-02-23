<?php
// All Deployer recipes are based on `recipe/common.php`.
require 'recipe/common.php';
require '../vendor/deployphp/recipes/recipes/configure.php';

set('keep_releases', 5);
set('repository', 'https://github.com/phaniso/phpmonitor-Api.git');
set('writable_dirs', ['src/logs']);
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'deploy:configure');
after('deploy', 'success');

serverList('config/servers.yml');
