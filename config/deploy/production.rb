# Set the github branch that will be used for this deployment.
set :branch, "main"

# Default value for keep_releases is 5
set :keep_releases, 3

# Set the host and user as separate variables since Capistrano 3 doesn’t seem to have an easy way to access that info.
# TODO: Figure out a better way to do this since 'ENV["CAP_USER"]' will override the fallback in the 'server' setup logic.
deploy_hosts = [ "szwergold.com" ]
set :deploy_user, "jackgold"

# Set the details of the destination server you will be deploying to.
deploy_hosts.each { |deploy_host|
  server deploy_host, user: ENV["CAP_USER"] || fetch(:deploy_user), roles: %w{app db web}, my_property: :my_value
}

# Set the name for the deployment type.
set :deployment_type, "production"

# Set the 'deploy_to' directory for this task.
set :deploy_to, "#{fetch(:code_builds)}/#{fetch(:application)}/#{fetch(:deployment_type)}"

# Set the 'configs_path' directory for this task.
set :configs_path, "/home/jackgold/configs/#{fetch(:application)}/#{fetch(:deployment_type)}"
# set :configs_path, "/var/www/configs/#{fetch(:deployment_type)}"
# set :configs_path, "/var/www/configs"

# Set the code root path. Can be overridden in individual stages.
set :code_root_path, "/home/jackgold"

# Set the MySQL database paths and patterns.
set :db_dir_local, "development_dbs/"
set :db_dir_remote, "/home/jackgold/zzz_mysql_backups/"
set :db_file_pattern, "szwergold_wp_db"

# Set the MySQL database stuff.
set :mysql_host_remote, "szwergold.com"
set :mysql_bin_mamp, "/Applications/MAMP/Library/bin/mysql"
set :mysql_port_mamp, 8889
set :mysql_db_mamp, "szwergold_wp_db"
set :mysqldump_bin_mamp, "/Applications/MAMP/Library/bin/mysqldump"
set :mysqldump_db_mamp, "szwergold_wp_db"

# Set the files and content path stuff.
set :files_host_remote, "szwergold.com"
set :files_plugins_dir_local, "wp-content/plugins/"
set :files_plugins_dir_remote, "#{fetch(:code_builds)}/#{fetch(:application)}/#{fetch(:deployment_type)}/current/wp-content/plugins/"
set :files_themes_dir_local, "wp-content/themes/"
set :files_themes_dir_remote, "#{fetch(:code_builds)}/#{fetch(:application)}/#{fetch(:deployment_type)}/current/wp-content/themes/"
set :files_uploads_dir_local, "wp-content/uploads/"
set :files_uploads_dir_remote, "#{fetch(:code_builds)}/#{fetch(:application)}/#{fetch(:deployment_type)}/shared/wp-content/uploads/"
