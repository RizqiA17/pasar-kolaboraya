<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PasarKolaborayaExportController extends Controller
{
    /**
     * Export users data to CSV format
     */
    public function exportCsv(PasarKolaboraya $pasarKolaboraya)
    {
        // Check authorization
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isSuperAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $fileName = 'pasar_kolaboraya_users_' . $pasarKolaboraya->id . '_' . date('Y-m-d_His') . '.csv';

        return $this->streamCsvResponse($pasarKolaboraya, $fileName);
    }

    /**
     * Export users data to SQL format
     */
    public function exportSql(PasarKolaboraya $pasarKolaboraya)
    {
        // Check authorization
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isSuperAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $fileName = 'pasar_kolaboraya_users_' . $pasarKolaboraya->id . '_' . date('Y-m-d_His') . '.sql';

        return $this->streamSqlResponse($pasarKolaboraya, $fileName);
    }

    /**
     * Stream CSV response with optimized memory usage
     */
    private function streamCsvResponse(PasarKolaboraya $pasarKolaboraya, string $fileName): StreamedResponse
    {
        $filename = 'pasar_kolaboraya_users_' . $pasarKolaboraya->id . '_' . date('Y-m-d_His') . '.csv';

        return new StreamedResponse(function () use ($pasarKolaboraya) {
            $handle = fopen('php://output', 'w');

            // Tambahkan BOM agar Excel membaca UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header CSV
            $headers = [
                'qr_code',
                'qr_code_svg',
                'full_name',
                'email',
                'phone',
                'institution',
                'peran',
                'notes',
            ];

            fputcsv($handle, $headers);

            $pasarKolaboraya->users()
                ->wherePivot('status', 'accepted')
                ->where('users.role', 'user')
                ->select([
                    'users.id',
                    'users.qr_code',
                    'users.name',
                    'users.email',
                    'users.phone_number',
                    'users.organization_name',
                    'users.assigned_role',
                ])
                ->chunk(100, function ($users) use ($handle) {
                    foreach ($users as $user) {
                        $qrSvg = '';
                        if (!empty($user->qr_code)) {
                            // Generate QR code SVG
                            $qrSvg = QrCode::format('svg')
                                ->size(150)
                                ->generate($user->qr_code);

                            // Hapus break line agar svg satu baris
                            $qrSvg = str_replace(["\n", "\r"], '', $qrSvg);
                        }

                        $row = [
                            $user->qr_code ?? '',
                            $qrSvg,
                            $user->name ?? '',
                            $user->email ?? '',
                            $user->phone_number ?? '',
                            $user->organization_name ?? '',
                            $user->assigned_role ?? '',
                            '', // notes kosong
                        ];

                        fputcsv($handle, $row);
                    }
                });

            fclose($handle);
        }, 200, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
        ]);

    }

    /**
     * Stream SQL response with optimized memory usage
     */
    private function streamSqlResponse(PasarKolaboraya $pasarKolaboraya, string $fileName): StreamedResponse
    {
        return new StreamedResponse(function () use ($pasarKolaboraya) {
            $handle = fopen('php://output', 'w');

            // SQL Header with comments
            $header = "-- Pasar Kolaboraya Users Data Export\n";
            $header .= "-- Pasar Kolaboraya: {$pasarKolaboraya->name}\n";
            $header .= "-- Export Date: " . date('Y-m-d H:i:s') . "\n";
            $header .= "-- Total Users: " . $pasarKolaboraya->acceptedUsers()->count() . "\n\n";
            $header .= "-- This SQL file contains INSERT statements for users and their relationship with Pasar Kolaboraya\n";
            $header .= "-- For on-site local application import\n\n";

            fwrite($handle, $header);

            // Start transaction
            fwrite($handle, "START TRANSACTION;\n\n");

            // Disable foreign key checks for import
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

            // Create tables if not exist
            fwrite($handle, "-- Create Tables (if not exist)\n");

            // Create users table
            fwrite($handle, "CREATE TABLE IF NOT EXISTS `users` (\n");
            fwrite($handle, "    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n");
            fwrite($handle, "    `name` varchar(255) NOT NULL,\n");
            fwrite($handle, "    `email` varchar(255) NOT NULL,\n");
            fwrite($handle, "    `gender` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `phone_number` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `organization_type` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `organization_name` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `role` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `user_type` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `assigned_role` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `approval_status` varchar(255) DEFAULT NULL,\n");
            fwrite($handle, "    `email_verified_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($handle, "    `password` varchar(255) NOT NULL,\n");
            fwrite($handle, "    `created_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($handle, "    `updated_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($handle, "    PRIMARY KEY (`id`),\n");
            fwrite($handle, "    UNIQUE KEY `users_email_unique` (`email`)\n");
            fwrite($handle, ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n");

            // Create pasar_kolaboraya_users table
            fwrite($handle, "CREATE TABLE IF NOT EXISTS `pasar_kolaboraya_users` (\n");
            fwrite($handle, "    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n");
            fwrite($handle, "    `pasar_kolaboraya_id` bigint(20) unsigned NOT NULL,\n");
            fwrite($handle, "    `user_id` bigint(20) unsigned NOT NULL,\n");
            fwrite($handle, "    `status` varchar(255) NOT NULL,\n");
            fwrite($handle, "    `role` varchar(255) NOT NULL,\n");
            fwrite($handle, "    `invited_by` bigint(20) unsigned DEFAULT NULL,\n");
            fwrite($handle, "    `join_reason` text DEFAULT NULL,\n");
            fwrite($handle, "    `joined_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($handle, "    `created_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($handle, "    `updated_at` timestamp NULL DEFAULT NULL,\n");
            fwrite($handle, "    PRIMARY KEY (`id`),\n");
            fwrite($handle, "    KEY `pasar_kolaboraya_users_pasar_kolaboraya_id_foreign` (`pasar_kolaboraya_id`),\n");
            fwrite($handle, "    KEY `pasar_kolaboraya_users_user_id_foreign` (`user_id`),\n");
            fwrite($handle, "    KEY `pasar_kolaboraya_users_invited_by_foreign` (`invited_by`)\n");
            fwrite($handle, ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n");

            // Users table inserts
            fwrite($handle, "-- Insert Users\n");

            $pasarKolaboraya->users()
                ->wherePivot('status', 'accepted')
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.gender',
                    'users.phone_number',
                    'users.organization_type',
                    'users.organization_name',
                    'users.role',
                    'users.user_type',
                    'users.assigned_role',
                    'users.approval_status',
                    'users.email_verified_at',
                    'users.password',
                    'users.created_at',
                    'users.updated_at',
                ])
                ->chunk(100, function ($users) use ($handle, $pasarKolaboraya) {
                    foreach ($users as $user) {
                        // Prepare user data
                        $userData = [
                            'id' => $user->id,
                            'name' => $this->escapeSql($user->name),
                            'email' => $this->escapeSql($user->email),
                            'gender' => $user->gender ? $this->escapeSql($user->gender) : 'NULL',
                            'phone_number' => $user->phone_number ? $this->escapeSql($user->phone_number) : 'NULL',
                            'organization_type' => $user->organization_type ? $this->escapeSql($user->organization_type) : 'NULL',
                            'organization_name' => $user->organization_name ? $this->escapeSql($user->organization_name) : 'NULL',
                            'role' => $user->role ? $this->escapeSql($user->role) : 'NULL',
                            'user_type' => $user->user_type ? $this->escapeSql($user->user_type) : 'NULL',
                            'assigned_role' => $user->assigned_role ? $this->escapeSql($user->assigned_role) : 'NULL',
                            'approval_status' => $user->approval_status ? $this->escapeSql($user->approval_status) : 'NULL',
                            'email_verified_at' => $user->email_verified_at ? "'" . $user->email_verified_at->format('Y-m-d H:i:s') . "'" : 'NULL',
                            'password' => $this->escapeSql($user->password),
                            'created_at' => $user->created_at ? "'" . $user->created_at->format('Y-m-d H:i:s') . "'" : 'NULL',
                            'updated_at' => $user->updated_at ? "'" . $user->updated_at->format('Y-m-d H:i:s') . "'" : 'NULL',
                        ];

                        $sql = "INSERT INTO `users` (`id`, `name`, `email`, `gender`, `phone_number`, `organization_type`, `organization_name`, `role`, `user_type`, `assigned_role`, `approval_status`, `email_verified_at`, `password`, `created_at`, `updated_at`) VALUES ";
                        $sql .= "({$userData['id']}, {$userData['name']}, {$userData['email']}, {$userData['gender']}, {$userData['phone_number']}, {$userData['organization_type']}, {$userData['organization_name']}, {$userData['role']}, {$userData['user_type']}, {$userData['assigned_role']}, {$userData['approval_status']}, {$userData['email_verified_at']}, {$userData['password']}, {$userData['created_at']}, {$userData['updated_at']})";
                        $sql .= " ON DUPLICATE KEY UPDATE ";
                        $sql .= "`name`=VALUES(`name`), ";
                        $sql .= "`email`=VALUES(`email`), ";
                        $sql .= "`gender`=VALUES(`gender`), ";
                        $sql .= "`phone_number`=VALUES(`phone_number`), ";
                        $sql .= "`organization_type`=VALUES(`organization_type`), ";
                        $sql .= "`organization_name`=VALUES(`organization_name`), ";
                        $sql .= "`assigned_role`=VALUES(`assigned_role`), ";
                        $sql .= "`updated_at`=VALUES(`updated_at`);\n";

                        fwrite($handle, $sql);
                    }
                });

            fwrite($handle, "\n-- Insert Pasar Kolaboraya Relationships\n");

            // Pasar Kolaboraya relationship inserts
            $pasarKolaboraya->pasarKolaborayaUsers()
                ->where('status', 'accepted')
                ->select([
                    'id',
                    'pasar_kolaboraya_id',
                    'user_id',
                    'status',
                    'role',
                    'invited_by',
                    'join_reason',
                    'joined_at',
                    'created_at',
                    'updated_at',
                ])
                ->chunk(100, function ($pivots) use ($handle) {
                    foreach ($pivots as $pivot) {
                        $pivotData = [
                            'id' => $pivot->id,
                            'pasar_kolaboraya_id' => $pivot->pasar_kolaboraya_id,
                            'user_id' => $pivot->user_id,
                            'status' => $this->escapeSql($pivot->status),
                            'role' => $this->escapeSql($pivot->role),
                            'invited_by' => $pivot->invited_by ?? 'NULL',
                            'join_reason' => $pivot->join_reason ? $this->escapeSql($pivot->join_reason) : 'NULL',
                            'joined_at' => $pivot->joined_at ? "'" . date('Y-m-d H:i:s', strtotime($pivot->joined_at)) . "'" : 'NULL',
                            'created_at' => $pivot->created_at ? "'" . $pivot->created_at->format('Y-m-d H:i:s') . "'" : 'NULL',
                            'updated_at' => $pivot->updated_at ? "'" . $pivot->updated_at->format('Y-m-d H:i:s') . "'" : 'NULL',
                        ];

                        $sql = "INSERT INTO `pasar_kolaboraya_users` (`id`, `pasar_kolaboraya_id`, `user_id`, `status`, `role`, `invited_by`, `join_reason`, `joined_at`, `created_at`, `updated_at`) VALUES ";
                        $sql .= "({$pivotData['id']}, {$pivotData['pasar_kolaboraya_id']}, {$pivotData['user_id']}, {$pivotData['status']}, {$pivotData['role']}, {$pivotData['invited_by']}, {$pivotData['join_reason']}, {$pivotData['joined_at']}, {$pivotData['created_at']}, {$pivotData['updated_at']})";
                        $sql .= " ON DUPLICATE KEY UPDATE ";
                        $sql .= "`status`=VALUES(`status`), ";
                        $sql .= "`role`=VALUES(`role`), ";
                        $sql .= "`updated_at`=VALUES(`updated_at`);\n";

                        fwrite($handle, $sql);
                    }
                });

            // Re-enable foreign key checks
            fwrite($handle, "\nSET FOREIGN_KEY_CHECKS=1;\n\n");

            // Commit transaction
            fwrite($handle, "COMMIT;\n\n");

            fwrite($handle, "-- Export completed successfully\n");

            fclose($handle);
        }, 200, [
            'Content-Type' => 'application/sql; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Escape string for SQL
     */
    private function escapeSql($value): string
    {
        if (is_null($value)) {
            return 'NULL';
        }

        // Escape special characters
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace("'", "\'", $value);
        $value = str_replace("\n", '\\n', $value);
        $value = str_replace("\r", '\\r', $value);
        $value = str_replace("\x00", '\\0', $value);
        $value = str_replace("\x1a", '\\Z', $value);

        return "'" . $value . "'";
    }
}

