@servers(['web' => 'deployer@myIP'])

@setup
    $repository = 'git@gitlab.com:devicepixel/api.git';
    $releases_dir = '/var/www/html/api/master/releases';
    $app_dir = '/var/www/html/api/master';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
    clone_repository
    run_composer
    update_permissions
    update_symlinks
@endstory

@story('deploy_develop')
    pull_develop
@endstory

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer install --prefer-dist --no-scripts -q -o
@endtask

@task('update_permissions')
    echo "Updating permissions"
    chmod 777 {{ $new_release_dir }}/bootstrap/cache;
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('pull_develop')
    echo "Pulling develop"
    cd /var/www/html/api/dev
    git pull origin develop
    composer install
    composer dump-autoload
    php artisan migrate
@endtask