<?php
session_start();

function backupDatabase($host, $user, $password, $database, $backupFile)
{
    $command = "mysqldump --opt --host=$host --user=$user --password=$password $database > $backupFile";

    exec($command, $output, $return_var);

    if ($return_var === 0) {

        if (file_exists($backupFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($backupFile) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backupFile));
            readfile($backupFile);

            unlink($backupFile);
            exit;
        } else {
            echo "Error: Backup file not found.";
        }
    } else {
        echo "Error creating database backup. Command output: " . implode("\n", $output);
    }
}

$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'bagkat_database';
$backupFile = 'bagkat_database_' . date('Y-m-d') . '.sql';

backupDatabase($host, $user, $password, $database, $backupFile);
