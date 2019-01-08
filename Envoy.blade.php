@servers(['web' => 'root@111.231.66.72'])

@task('deploy')
    cd /home/patient
    git checkout .
    git pull origin master
    php artisan migrate
@endtask
