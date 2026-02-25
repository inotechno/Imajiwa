<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Illuminate\Console\Command;

class ExportAttendances extends Command
{
    protected $signature = 'attendance:export {--output=C:/attendance_export.sql}';
    protected $description = 'Export attendances table to SQL file for migration to server';

    public function handle()
    {
        $outputPath = $this->option('output');
        $fp = fopen($outputPath, 'w');

        fwrite($fp, "SET NAMES utf8mb4;\n");
        fwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $total = Attendance::count();
        $this->info("Exporting {$total} records...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $exported = 0;
        Attendance::orderBy('id')->chunk(500, function ($rows) use ($fp, $bar, &$exported) {
            foreach ($rows as $row) {
                $data = $row->toArray();
                $columns = '`' . implode('`, `', array_keys($data)) . '`';
                $values = implode(', ', array_map(function ($v) {
                    if ($v === null) return 'NULL';
                    return "'" . addslashes((string) $v) . "'";
                }, array_values($data)));
                fwrite($fp, "INSERT IGNORE INTO `attendances` ({$columns}) VALUES ({$values});\n");
                $exported++;
                $bar->advance();
            }
        });

        $bar->finish();
        fclose($fp);

        $this->newLine();
        $this->info("Done! Exported {$exported} records to: {$outputPath}");
        $this->info("File size: " . number_format(filesize($outputPath) / 1024 / 1024, 2) . " MB");

        return 0;
    }
}
