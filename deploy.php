<?php
namespace Deployer;

require 'recipe/common.php';

// Hosts

host('notes.vakhrushev.me')
    ->user('notes')
    ->stage('production')
    ->set('deploy_path', '/var/www/notes')
;

host('192.168.50.10')
    ->user('notes')
    ->stage('staging')
    ->set('deploy_path', '/var/www/notes')
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
;

// Project name
set('application', 'Notes');

// Project repository
set('repository', 'git@github.com:anwinged/notes.git');

// Saved releases
set('keep_releases', 2);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Timeout for script execution
set('default_timeout', 1800);

task('deploy:copy_env', function () {
    within('{{release_path}}', function () {
        run('cp -f /home/notes/.env .');
    });
});

task('deploy:build_images', function () {
    within('{{release_path}}', function () {
        run('make build');
    });
});

task('deploy:up_containers', function () {
    within('{{release_path}}', function () {
        run('make up');
        run('sleep 30');
    });
});


task('deploy:application', function () {
    within('{{release_path}}', function () {
        run('make migrate');
        run('make reindex-search-db');
        run('make console A="cache:clear"');
    });
});

// --------------------------------------------------------
// Main tasks
// --------------------------------------------------------

/**
 * Main task
 */
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:copy_env',
    'deploy:build_images',
    'deploy:up_containers',
    'deploy:application',
    'deploy:unlock',
    'cleanup',
]);

after('deploy', 'success');

after('deploy:failed', 'deploy:unlock');
