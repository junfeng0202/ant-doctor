@servers(['web' => 'root@111.231.66.72'])

@task('deploy')
    cd /path/to/site
    git pull origin master
@endtask
