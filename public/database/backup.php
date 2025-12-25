<?php
// Simple backup script
$backupFile = 'backups/backup-' . date('Y-m-d-H-i-s') . '.sql';
$command = "mysqldump --user=root --password= --host=localhost pharmacy_platform > $backupFile";
system($command);
echo "Backup created: $backupFile";