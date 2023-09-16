#!/usr/bin/env bash

input=$*

set -e

echo 'upload_max_filesize = 100M' >> /etc/php/8.2/cli/php.ini && \
echo 'post_max_size = 100M' >> /etc/php/8.2/cli/php.ini && \
echo 'memory_limit = 512M' >> /etc/php/8.2/cli/php.ini && \
echo 'max_execution_time = 600' >> /etc/php/8.2/cli/php.ini && \
echo 'max_input_time = 600' >> /etc/php/8.2/cli/php.ini && \
echo 'max_input_vars = 10000' >> /etc/php/8.2/cli/php.ini && \
echo 'date.timezone = "UTC"' >> /etc/php/8.2/cli/php.ini

echo "opcache.enable_cli=1" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.validate_timestamps=1" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.revalidate_freq=0" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.use_cwd=1" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.max_accelerated_files=100000" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.max_wasted_percentage=5" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.memory_consumption=128" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.consistency_checks=1" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.file_cache_consistency_checks=1" >> /etc/php/8.2/mods-available/opcache.ini

echo "opcache.consistency_checks=0" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.revalidate_freq=60" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.preload=/app/config/preload.php" >> /etc/php/8.2/mods-available/opcache.ini
echo "opcache.preload_user=www-data" >> /etc/php/8.2/mods-available/opcache.ini

if [ -z "$input" ]; then
    echo "Command MUST be set....Exit!"
    exit 1;
else
    echo "Executing: $input"
    eval "$input"
fi
