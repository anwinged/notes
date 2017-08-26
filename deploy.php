<?php
namespace Deployer;

require 'recipe/common.php';

// Hosts

host('anwinged.ru')
    ->user('deployer')
    ->stage('production')
    ->set('deploy_path', '/var/www/notes')
;

host('192.168.50.10')
    ->user('deployer_test')
    ->stage('testing')
    ->set('deploy_path', '/var/www/notes')
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
;

// Project name
set('application', 'Notes');

// Project repository
set('repository', 'git@github.com:anwinged/note.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Symfony build set
set('symfony_env', 'prod');

// Symfony executable and variable directories
set('bin_dir', 'bin');
set('var_dir', 'var');

// Symfony shared dirs
set('shared_dirs', ['var/logs', 'var/sessions']);

// Symfony shared files
set('shared_files', ['app/config/parameters.yml']);

// Symfony writable dirs
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions']);

// Clear paths
set('clear_paths', ['web/app_*.php', 'web/config.php']);

// Assets
set('assets', ['web/css', 'web/images', 'web/js']);

// Excluded dirs for upload
set('upload_excluded_dirs', [
    '.git',
    'ansible',
    'client',
    'node_modules',
]);

// Requires non symfony-core package `kriswallsmith/assetic` to be installed
set('dump_assets', false);

// Environment vars
set('env', function () {
    return [
        'SYMFONY_ENV' => get('symfony_env')
    ];
});

// Symfony console bin
set('bin/console', function () {
    return sprintf('{{release_path}}/%s/console', trim(get('bin_dir'), '/'));
});

// Symfony console opts
set('console_options', function () {
    $options = '--no-interaction --env={{symfony_env}}';
    return get('symfony_env') !== 'prod' ? $options : sprintf('%s --no-debug', $options);
});

// Binary for npm
set('bin/npm', function () {
    return locateBinaryPath('npm');
});

// Directory for building application
set('build_dir', '/tmp/build-notes');

/**
 * Create cache dir
 */
task('deploy:create_cache_dir', function () {
    // Set cache dir
    set('cache_dir', '{{release_path}}/' . trim(get('var_dir'), '/') . '/cache');
    // Remove cache dir if it exist
    run('if [ -d "{{cache_dir}}" ]; then rm -rf {{cache_dir}}; fi');
    // Create cache dir
    run('mkdir -p {{cache_dir}}');
    // Set rights
    run("chmod -R g+w {{cache_dir}}");
})->desc('Create cache dir');

/**
 * Clear Cache
 */
task('deploy:cache:clear', function () {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}} --no-warmup');
})->desc('Clear cache');

/**
 * Warm up cache
 */
task('deploy:cache:warmup', function () {
    run('{{bin/php}} {{bin/console}} cache:warmup {{console_options}}');
})->desc('Warm up cache');

/**
 * Migrate database
 */
task('database:migrate', function () {
    run('{{bin/php}} {{bin/console}} doctrine:migrations:migrate {{console_options}} --allow-no-migration');
})->desc('Migrate database');

/**
 * Install node packages
 */
task('assets:npm:install', function () {
    run('cd {{release_path}} && {{bin/npm}} install');
});

/**
 * Build assets
 */
task('assets:npm:build', function () {
    run('cd {{release_path}} && {{bin/npm}} run build-prod');
});

// --------------------------------------------------------
// Main tasks
// --------------------------------------------------------

/**
 * Build app sources
 */
task('build', function () {
    set('deploy_path', get('build_dir'));
    invoke('deploy:info');
    invoke('deploy:prepare');
    invoke('deploy:release');
    invoke('deploy:update_code');
    invoke('deploy:vendors');
    invoke('deploy:clear_paths');
    invoke('assets:npm:install');
    invoke('assets:npm:build');
    invoke('deploy:symlink');
})->local();

/**
 * Upload app sources on remote host
 */
task('upload', function () {
    $excluded = array_map(function ($dir) {
        return sprintf('--exclude "%s"', $dir);
    }, get('upload_excluded_dirs'));
    upload(get('build_dir') . '/current/', '{{release_path}}', [
        'options' => $excluded,
    ]);
});

/**
 * Prepare app sources for production
 */
task('release', [
    'deploy:prepare',
    'deploy:release',
    'upload',
    'deploy:shared',
    'deploy:writable',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'database:migrate',
    'deploy:symlink',
]);

/**
 * Main task: deploy application
 */
desc('Deploy your project');
task('deploy', [
    'build',
    'release',
    'cleanup',
    'success',
]);

// If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
