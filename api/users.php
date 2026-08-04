<?php
// 1. Inisialisasi Environment Bitrix
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Type\Date;

// Memastikan modul utama siap (opsional tapi baik untuk keamanan)
if (!Loader::includeModule('main')) {
    die("Gagal memuat modul Main");
}

// 2. Konfigurasi Path
$jsonFilePath = $_SERVER["DOCUMENT_ROOT"] . "/api/loyalty/user/cards/users.json";
$logPath = '/log_1c/___user_cards_sync.txt'; // Path log yang rapi

// 3. Validasi File JSON
if (!file_exists($jsonFilePath)) {
    Debug::writeToFile("File tidak ditemukan: $jsonFilePath", "ERROR", $logPath);
    exit("Error: File JSON tidak ditemukan.");
}

$jsonData = file_get_contents($jsonFilePath);
$userList = json_decode($jsonData);

if (!is_array($userList)) {
    Debug::writeToFile("Format JSON Salah atau Kosong: " . json_last_error_msg(), "ERROR", $logPath);
    exit("Error: Format JSON tidak valid.");
}

/**
 * Fungsi Normalisasi Telepon
 */
function normalizePhoneCustom($phone) {
    $digits = preg_replace('/\D/', '', $phone);
    if (strlen($digits) === 10 && $digits[0] === '0') {
        return '38' . $digits;
    } elseif (strlen($digits) === 12 && strpos($digits, '38') === 0) {
        return $digits;
    }
    return '';
}

// 4. Inisialisasi Counter untuk Laporan
$stats = [
    'total'    => 0,
    'updated'  => 0,
    'skipped'  => 0,
    'not_found' => 0,
    'errors'   => 0
];

$userObj = new CUser;

// 5. Proses Sinkronisasi
foreach ($userList as $userItem) {
    $stats['total']++;

    if (empty($userItem->phone) || empty($userItem->xml_id)) {
        continue;
    }

    $normalizedPhone = normalizePhoneCustom($userItem->phone);
    if (!$normalizedPhone) {
        continue;
    }

    // Cari User berdasarkan nomor telepon
    $rsUsers = CUser::GetList(
        $by = "ID",
        $order = "ASC",
        ["UF_PHONE_CLEAN" => $normalizedPhone],
        ["SELECT" => ["ID", "XML_ID"]]
    );

    if ($arUser = $rsUsers->Fetch()) {
        
        // JIKA XML_ID SUDAH ADA, KITA SKIP (Agar Aman)
        if (!empty($arUser["XML_ID"])) {
            $stats['skipped']++;
            continue;
        }

        // Siapkan data update
        $updateFields = [
            "XML_ID" => $userItem->xml_id
        ];

        // Format Tanggal Lahir (Asumsi format JSON: YYYYMMDD...)
        if (!empty($userItem->datebirthday)) {
            $rawDate = substr($userItem->datebirthday, 0, 8);
            $timestamp = strtotime($rawDate);
            if ($timestamp) {
                $updateFields["PERSONAL_BIRTHDAY"] = Date::createFromTimestamp($timestamp)->format("d.m.Y");
            }
        }

        // Eksekusi Update
        $res = $userObj->Update($arUser["ID"], $updateFields);

        if ($res) {
            $stats['updated']++;
            Debug::writeToFile(
                "ID: {$arUser['ID']} | Phone: $normalizedPhone | XML_ID: {$userItem->xml_id} diperbarui.",
                "SUCCESS",
                $logPath
            );
        } else {
            $stats['errors']++;
            Debug::writeToFile("Gagal update ID {$arUser['ID']}: " . $userObj->LAST_ERROR, "UPDATE_ERROR", $logPath);
        }

    } else {
        $stats['not_found']++;
        // Log user yang tidak ditemukan di DB (Opsional)
        Debug::writeToFile("Telepon $normalizedPhone tidak ditemukan di database.", "NOT_FOUND", '/log_1c/not_found_users.txt');
    }
}

// 6. Output Sederhana
echo "<h3>Proses Selesai</h3>";
echo "<ul>
    <li>Total Data JSON: {$stats['total']}</li>
    <li>Berhasil Diupdate: {$stats['updated']}</li>
    <li>Dilewati (Sudah ada XML_ID): {$stats['skipped']}</li>
    <li>Tidak Ditemukan: {$stats['not_found']}</li>
    <li>Error Update: {$stats['errors']}</li>
</ul>";
echo "Cek log di: <b>$logPath</b> untuk detailnya.";