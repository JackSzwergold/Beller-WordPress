# config valid only for current version of Capistrano
lock ['>= 3.17.0', '<= 3.20.0']

set :application, 'szwergold.com'
set :short_name, 'szwergold.com'
set :repo_url, 'git@github.com:JackSzwergold/Szwergold-WordPress.git'

# Default value for :format is :pretty
set :format, :pretty

# Default value for :log_level is :debug
set :log_level, :info

# Default value for :pty is false
set :pty, false

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')
set :linked_dirs, fetch(:linked_dirs, []).push('wp-content/uploads', 'wp-content/upgrade')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 3

# Disable warnings about the absence of the styleseheets, javscripts & images directories.
set :normalize_asset_timestamps, false

# The directory on the server into which the actual source code will deployed.
set :code_builds, "/home/jackgold/builds"

# Set the code root path. Can be overridden in individual stages.
set :code_root_path, "/home/jackgold"

namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

  # Echo the current path to a file. Needed for WordPress deployments.
  desc "Echo the current path."
  task :echo_current_path do
    on roles(:app) do

        execute "echo #{release_path} > #{release_path}/CURRENT_PATH"

    end
  end

  # Create the 'create_symlinks' task to create symbolic links and other related items.
  desc "Set the symbolic links."
  task :create_symlinks do
    on roles(:app) do

      # info "Link the 'local.php' config to 'local.php' in the working directory."
      execute "cd #{current_path} && ln -sf #{fetch(:configs_path)}/wp-config.php wp-config.php"

      # info "If there isn’t a symbolic link to '#{fetch(:short_name)}' then create a symbolic link called '#{fetch(:short_name)}'."
      execute "cd #{fetch(:code_root_path)} && if [ ! -h #{fetch(:short_name)} ]; then if [ ! -d #{fetch(:short_name)} ]; then ln -sf #{current_path} ./#{fetch(:short_name)}; fi; fi"

    end
  end

  # Remove repository cruft from the deployment.
  desc "Remove cruft from the deployment."
  task :remove_cruft do
    on roles(:app) do

      # Remove files and directories that aren’t needed on a deployed install.
      execute "cd #{current_path} && if [ -f robots.txt ]; then mv -f robots.txt robots.temp; fi && rm -rf {development_dbs,config,Capfile,*.html,*.txt,*.md,*.sql,.gitignore} && if [ -f 'robots.temp' ]; then mv -f robots.temp robots.txt; fi"

    end
  end

  # Set group write permissions to the deployment.
  desc "Set group write permissions to the deployment."
  task :set_group_write do
    on roles(:app) do

      # Set group write permissions to the deployment.
      execute "cd #{current_path} && chmod -R g+w ."

    end
  end

end

# Sundry tasks too run after the deployment has completed.
after "deploy:published", "deploy:echo_current_path"
after "deploy:published", "deploy:create_symlinks"
after "deploy:published", "deploy:set_group_write"
after "deploy:finishing", "deploy:remove_cruft"

# Load Rake tasks.
load "config/tasks/database.rake"
load "config/tasks/files.rake"
