<?php
class ImportExcelKatalogModel extends Models
{
    private $table_produk = "[um_db_bmi].[dbo].ProdukKatalog";


 public function saveData()
{
    try {
        if (!isset($_POST["data"])) {
            return array(
                "status"  => "error",
                "message" => "Data POST tidak ditemukan."
            );
        }

        $rawData = $_POST["data"];
        $post    = json_decode($rawData, true);
        $IDimport = isset($post["idimport"]) ? $post["idimport"] : null;

        // Pastikan file diupload
        if (!isset($_FILES["files"]) || $_FILES["files"]["error"] !== 0) {
            return array(
                "status"  => "error",
                "message" => "File tidak diupload atau error!"
            );
        }

        $tmp_file = $_FILES["files"]["tmp_name"];

        // --- Baca file Excel ---
        $reader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $reader->load($tmp_file);
        $sheet = $objPHPExcel->getActiveSheet();

        $rows = $sheet->toArray(null, true, true, true);
        $countRow = count($rows);

        if ($countRow < 10) {
            return array(
                "status"  => "error",
                "message" => "Jumlah baris tidak cukup. Gunakan template yang benar."
            );
        }

        // Header di baris 8 dan 9
        $header1 = isset($rows[8]) ? $rows[8] : null;
        $header2 = isset($rows[9]) ? $rows[9] : null;

        if (!$header1 || !$header2) {
            return array(
                "status"  => "error",
                "message" => "❌ Header Excel tidak ditemukan di baris 8–9. Gunakan template yang benar."
            );
        }

        // Gabungkan dua baris header
        $finalHeader = $this->combineExcelHeaders($header1, $header2);

        // Header yang diharapkan
        $expectedHeaders = array(
            'B' => 'NO',
            'C' => 'JENIS',
            'D' => 'KATEGORI',
            'E' => 'PARTID',
            'F' => 'GAMBAR',
            'G' => 'PRODUK SPESIFIKASI | UKURAN KARTON',
            'H' => 'PRODUK SPESIFIKASI | RAW MATERIAL',
            'I' => 'PRODUK SPESIFIKASI | MEKANIK',
            'J' => 'UKURAN',
            'K' => 'KAPASITAS',
            'M' => 'PUNGGUNG',
            'O' => 'LABEL PUNGGUNG',
            'P' => 'FITUR',
            'Q' => 'WARNA',
            'S' => 'VIDEO'
        );

        // Validasi header
        $checkHeader = $this->validateExcelHeader($finalHeader, $expectedHeaders);
        if ($checkHeader["status"] === "error") {
            return $checkHeader;
        }

        $username = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : 'unknown';
        $duplicateList = array();

        // --- Proses setiap baris data ---
        foreach ($rows as $index => $row) {
            if ($index <= 9) continue; // lewati header

            $no            = trim($row["B"]);
            $jenis         = trim($row["C"]);
            $kategori      = trim($row["D"]);
            $partid        = trim($row["E"]);
            $gambar        = trim($row["F"]);
            $ukuran_karton = trim($row["G"]);
            $row_material  = trim($row["H"]);
            $mekanik       = trim($row["I"]);
            $ukuran        = trim($row["J"]);
            $kapasitas     = trim($row["K"]);
            $punggung      = trim($row["M"]);
            $label_punggung = trim($row["O"]);
            $fitur         = trim($row["P"]);
            $warna         = trim($row["Q"]);
            $video         = trim($row["S"]);

            // Lewati baris kosong
            if ($no === '' && $partid === '') continue;

            // Escape tanda kutip
            $partid = str_replace("'", "''", $partid);

            // --- Cek duplikat PartID ---
            $cekQuery = "
                SELECT COUNT(*) AS jml 
                FROM " . $this->table_produk . " 
                WHERE Partid = '{$partid}'
            ";
            $cekResult = $this->db->baca_sql($cekQuery);

            if ($cekResult && isset($cekResult[0]["jml"]) && $cekResult[0]["jml"] > 0) {
                $duplicateList[] = $partid;
                continue; // skip insert
            }

            // Escape semua input
            $escape = function ($val) {
                return str_replace("'", "''", trim($val));
            };

            $no            = $escape($no);
            $jenis         = $escape($jenis);
            $kategori      = $escape($kategori);
            $gambar        = $escape($gambar);
            $ukuran_karton = $escape($ukuran_karton);
            $row_material  = $escape($row_material);
            $mekanik       = $escape($mekanik);
            $ukuran        = $escape($ukuran);
            $kapasitas     = $escape($kapasitas);
            $punggung      = $escape($punggung);
            $label_punggung = $escape($label_punggung);
            $fitur         = $escape($fitur);
            $warna         = $escape($warna);
            $video         = $escape($video);

            // ✅ Aman untuk SQL Server 2000 (IF NOT EXISTS)
            $query = "
                IF NOT EXISTS (SELECT 1 FROM " . $this->table_produk . " WHERE Partid = '{$partid}')
                BEGIN
                    INSERT INTO " . $this->table_produk . " 
                    (NoExel, Jenis, Kategori, Partid, Gambar, UkuranKarton, RawMaterial, Mekanik, Ukuran,
                    Kapasitas, Punggung, LabelPunggung, Fitur, KodeWarna, Video, CreateUser)
                    VALUES
                    ('{$no}', '{$jenis}', '{$kategori}', '{$partid}', '{$gambar}', '{$ukuran_karton}', '{$row_material}', '{$mekanik}', '{$ukuran}',
                    '{$kapasitas}', '{$punggung}', '{$label_punggung}', '{$fitur}', '{$warna}', '{$video}', '{$username}')
                END
            ";

            $this->db->baca_sql2($query);
        }

        // --- Hasil akhir ---
        if (count($duplicateList) > 0) {
            return array(
                "status"  => "warning",
                "message" => "⚠️ Upload selesai, namun beberapa PartID sudah ada dan dilewati.",
                "duplikat" => $duplicateList
            );
        }

        return array(
            "status"  => "success",
            "message" => "✅ Upload import Excel ke katalog berhasil tanpa duplikat."
        );

    } catch (Exception $e) {
        return array(
            "status"  => "error",
            "message" => "Terjadi kesalahan sistem: " . $e->getMessage()
        );
    }
}


    /**
     * Gabungkan dua baris header Excel (untuk merge cell)
     */
    private function combineExcelHeaders($header1, $header2)
    {
        $finalHeader = array();
        $lastMainHeader = '';

        foreach ($header1 as $col => $val1) {
            $val1 = trim($val1);
            $val2 = isset($header2[$col]) ? trim($header2[$col]) : '';

            // Jika header utama kosong (karena merge), pakai header sebelumnya
            if ($val1 === '') {
                $val1 = $lastMainHeader;
            } else {
                $lastMainHeader = $val1;
            }

            // Gabungkan dua baris header
            if ($val2 !== '') {
                $finalHeader[$col] = strtoupper($val1 . ' | ' . $val2);
            } else {
                $finalHeader[$col] = strtoupper($val1);
            }
        }

        return $finalHeader;
    }

    /**
     * Validasi kesesuaian header Excel dengan template
     */
    private function validateExcelHeader($actualHeader, $expectedHeaders)
    {
        foreach ($expectedHeaders as $col => $expectedValue) {
            $actualValue = isset($actualHeader[$col]) ? strtoupper(trim($actualHeader[$col])) : '';

            if ($actualValue !== strtoupper($expectedValue)) {
                return array(
                    "status"  => "error",
                    "message" => "❌ Format file tidak sesuai di kolom {$col}. 
                    Ditemukan: '{$actualValue}', seharusnya: '{$expectedValue}'. 
                    Gunakan template Excel yang benar."
                );
            }
        }

        return array("status" => "ok");
    }
}
?>
