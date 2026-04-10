# A 'files' namespace for file directory related tasks.
namespace :files do

  # Call as 'cap [stage name] files:check_plugins'.
  desc "Check for new 'wp-content/plugins/' in the remote setup’s directory."
  task :check_plugins do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Check for new images from the remote setup’s files directory on \e[33m#{fetch(:files_host_remote)}\e[0m."
    system("rsync -avzt --dry-run #{fetch(:deploy_user)}@#{fetch(:files_host_remote)}:#{fetch(:files_plugins_dir_remote)} #{fetch(:files_plugins_dir_local)}")
  end

  # Call as 'cap [stage name] files:fetch_plugins'.
  desc "Fetch 'wp-content/plugins/' from the remote setup’s files directory to a local setup’s directory."
  task :fetch_plugins do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Fetch plugins from the remote setup’s files directory on \e[33m#{fetch(:files_host_remote)}\e[0m."
    system("rsync -avzt #{fetch(:deploy_user)}@#{fetch(:files_host_remote)}:#{fetch(:files_plugins_dir_remote)} #{fetch(:files_plugins_dir_local)}")
  end

  # Call as 'cap [stage name] files:check_themes'.
  desc "Check for new 'wp-content/themes/' in the remote setup’s directory."
  task :check_themes do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Check for new theme files from the remote setup’s files directory on \e[33m#{fetch(:files_host_remote)}\e[0m."
    system("rsync -avzt --dry-run #{fetch(:deploy_user)}@#{fetch(:files_host_remote)}:#{fetch(:files_themes_dir_remote)} #{fetch(:files_themes_dir_local)}")
  end

  # Call as 'cap [stage name] files:fetch_themes'.
  desc "Fetch 'wp-content/themes/' from the remote setup’s files directory to a local setup’s directory."
  task :fetch_themes do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Fetch theme files from the remote setup’s files directory on \e[33m#{fetch(:files_host_remote)}\e[0m."
    system("rsync -avzt #{fetch(:deploy_user)}@#{fetch(:files_host_remote)}:#{fetch(:files_themes_dir_remote)} #{fetch(:files_themes_dir_local)}")
  end

  # Call as 'cap [stage name] files:check_content'.
  desc "Check for new 'wp-content/uploads/' in the remote setup’s directory."
  task :check_uploads do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Check for new images from the remote setup’s files directory on \e[33m#{fetch(:files_host_remote)}\e[0m."
    system("rsync -avzt --dry-run --include='*/' --include='*.[Gg][Ii][Ff]' --include='*.[Jj][Pp][Gg]' --include='*.[Jj][Pp][Ee][Gg]' --include='*.[Pp][Nn][Gg]' --exclude='*' #{fetch(:deploy_user)}@#{fetch(:files_host_remote)}:#{fetch(:files_uploads_dir_remote)} #{fetch(:files_uploads_dir_local)}")
  end

  # Call as 'cap [stage name] files:fetch_content'.
  desc "Fetch 'wp-content/uploads/' from the remote setup’s files directory to a local setup’s directory."
  task :fetch_uploads do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Fetch uploads from the remote setup’s files directory on \e[33m#{fetch(:files_host_remote)}\e[0m."
    system("rsync -avzt --include='*/' --include='*.[Gg][Ii][Ff]' --include='*.[Jj][Pp][Gg]' --include='*.[Jj][Pp][Ee][Gg]' --include='*.[Pp][Nn][Gg]' --exclude='*' #{fetch(:deploy_user)}@#{fetch(:files_host_remote)}:#{fetch(:files_uploads_dir_remote)} #{fetch(:files_uploads_dir_local)}")
  end

end
