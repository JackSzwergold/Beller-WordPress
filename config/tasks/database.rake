# A 'database' namespace for database related tasks.
# TODO: The 'fetch_recent' is based on using calling out to the system and two SSH calls as a result. See if there is a way to steamline the logic.
namespace :database do

  # Call as 'cap [stage name] database:fetch_backup'.
  desc "Fetch the most recent MySQL database backup."
  task :fetch_backup do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Fetch a recent database backup from \e[33m#{fetch(:mysql_host_remote)}\e[0m."
    system("DB_RECENT=$(ssh #{fetch(:deploy_user)}@#{fetch(:mysql_host_remote)} ls -lrt #{fetch(:db_dir_remote)} | awk '/#{fetch(:db_file_pattern)}/ { f=$NF }; END { print f }'); scp #{fetch(:deploy_user)}@#{fetch(:mysql_host_remote)}:#{fetch(:db_dir_remote)}${DB_RECENT} #{fetch(:db_dir_local)}#{fetch(:deployment_type)}-${DB_RECENT};")
  end

  # Call as 'cap [stage name] database:trigger_backup'.
  desc "Trigger the MySQL database backup process."
  task :trigger_backup do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Triggering the MySQL backup process on \e[33m#{fetch(:mysql_host_remote)}\e[0m."
    system("ssh #{fetch(:deploy_user)}@#{fetch(:mysql_host_remote)} 'cd #{fetch(:code_root_path)} && ./mysql_dumps.sh >/dev/null 2>&1;'")
  end

  # Call as 'cap [stage name] database:import_mamp'.
  desc "Import a development database locally into MAMP."
  task :import_mamp do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Importing a development MySQL database locally into MAMP database named: \e[33m#{fetch(:mysql_db_mamp)}\e[0m"
    # system("DB_RECENT=$(ls -lrt #{fetch(:db_dir_local)} | awk '/#{fetch(:db_file_pattern)}/ { f=$NF }; END { print f }'); #{fetch(:mysql_bin_mamp)} -uroot -proot #{fetch(:mysql_db_mamp)} < #{fetch(:db_dir_local)}${DB_RECENT} >/dev/null 2>&1;")
    system("DB_RECENT=$(ls -lrt #{fetch(:db_dir_local)}#{fetch(:deployment_type)}-*.sql.gz | awk '/#{fetch(:db_file_pattern)}/ { f=$NF }; END { print f }'); echo ${DB_RECENT}; gzcat ${DB_RECENT} | #{fetch(:mysql_bin_mamp)} -uroot -proot --port=#{fetch(:mysql_port_mamp)} #{fetch(:mysql_db_mamp)} 2>&1 | grep -v 'Warning: Using a password';")
  end

  # Call as 'cap [stage name] database:export_mamp'.
  desc "Export a local development database from MAMP to a local development setup."
  task :export_mamp do
    puts "    \e[1m\e[34mRAKE TASK\e[0m\e[22m Exporting a local development database from MAMP to a local file named: \e[33m#{fetch(:db_dir_local)}#{fetch(:deployment_type)}-#{fetch(:mysqldump_db_mamp)}-YYYYmmDD-HHMM.sql.gz\e[0m"
    system("#{fetch(:mysqldump_bin_mamp)} --add-drop-table --user='root' --password='root' #{fetch(:mysql_db_mamp)} | gzip > #{fetch(:db_dir_local)}#{fetch(:deployment_type)}-#{fetch(:mysqldump_db_mamp)}-$(date +%Y%m%d)-$(date +%H%M).sql.gz 2>&1 | grep -v 'Warning: Using a password';")
  end

end
