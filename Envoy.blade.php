@servers(['web' => 'root@111.231.66.72'])

@task('deploy')
    cd /home/patient
    git checkout .
    git pull origin master
    /usr/local/php/bin/php artisan migrate
@endtask
