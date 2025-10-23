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
            'D' => 'HEAD KATEGORI',
            'E' => 'KATEGORI',
            'F' => 'PARTID',
            'G' => 'GAMBAR',
            'H' => 'PRODUK SPESIFIKASI | UKURAN KARTON',
            'I' => 'PRODUK SPESIFIKASI | RAW MATERIAL',
            'J' => 'PRODUK SPESIFIKASI | MEKANIK',
            'K' => 'UKURAN',
            'L' => 'KAPASITAS',
            'N' => 'PUNGGUNG',
            'P' => 'LABEL PUNGGUNG',
            'Q' => 'FITUR',
            'R' => 'WARNA',
            'T' => 'VIDEO'
        );

        // Validasi header
        $checkHeader = $this->validateExcelHeader($finalHeader, $expectedHeaders);
        if ($checkHeader["status"] === "error") {
            return $checkHeader;
        }

        $username = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : 'unknown';
        $duplicateList = array();

        //this->consol_war($rows);
        // --- Proses setiap baris data ---
        foreach ($rows as $index => $row) {
            if ($index <= 9) continue; // lewati header

            $no            = trim($row["B"]);
            $jenis         = trim($row["C"]);
            $headkategori      = trim($row["D"]);
            $subkategori      = trim($row["E"]);
            $partid        = trim($row["F"]);
            $gambar        = trim($row["G"]);
            $ukuran_karton = trim($row["H"]);
            $row_material  = trim($row["I"]);
            $mekanik       = trim($row["J"]);
            $ukuran        = trim($row["K"]);
            $kapasitas     = trim($row["L"]);
            $kapasitasukuran     = trim($row["M"]);
            $punggung             = trim($row["N"]);
            $punggung_ukuran      = trim($row["O"]);
            $label_punggung = trim($row["P"]);
            $fitur         = trim($row["Q"]);
            $warna         = trim($row["R"]);
            $warna_ukuran         = trim($row["S"]);
            $video         = trim($row["T"]);

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
            $headkategori      = $escape($headkategori);
            $subkategori      = $escape($subkategori);
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
                    (NoExel, Jenis, HeaderKategori,SubKategori, Partid, Gambar, UkuranKarton, RawMaterial, Mekanik, Ukuran,
                    Kapasitas, Punggung, LabelPunggung, Fitur, KodeWarna, Video, CreateUser,
                    KapasitasUkuran, PunggungUkuran, WaranUkuran)
                    VALUES
                    ('{$no}', '{$jenis}', '{$headkategori}','{$subkategori}', '{$partid}', '{$gambar}', '{$ukuran_karton}', '{$row_material}', '{$mekanik}', '{$ukuran}',
                    '{$kapasitas}', '{$punggung}', '{$label_punggung}', '{$fitur}', '{$warna}', '{$video}', '{$username}',
                    '{$kapasitasukuran}', '{$punggung_ukuran}', '{$warna_ukuran}')
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



    // untuk menamilkan kataloge 

    public function getkategori(){

        $query  ="USP_GetKategori";
        $result= $this->db->baca_sql2($query);
                    $datafull =[];
            while(odbc_fetch_row($result)){
                $datafull[] =[
                    "Kategori"=>rtrim(odbc_result($result,'HeaderKategori')),
                ];

            }
            
			 array_walk_recursive($datafull, function(&$value) {
				if (is_string($value)) {
					$value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
				}
			});
   
        return $datafull;
    }


     // untuk tampil data  produk list

   public function listdata()
    {
        // Ambil input JSON
        $data = file_get_contents('php://input');
        $post = json_decode($data, true);

        // Validasi dan normalisasi kategori
        $kategori = isset($post['kategori']) ? str_replace('-', ' ', trim($post['kategori'])) : '';

        if (empty($kategori)) {
            $this->consol_war("Kategori kosong, query dibatalkan.");
            return [];
        }

        // Buat query SQL (panggil stored procedure)
        $query = "EXEC USP_TampilProdukKatalog '{$kategori}'";
        // $this->consol_war("Menjalankan query: $query");

        // Jalankan query
        $result = $this->db->baca_sql2($query);

        // Siapkan array hasil
        $datafull = [];

        if ($result) {
            while (odbc_fetch_row($result)) {
                $datafull[] = [
                    "NoExel"          => trim(odbc_result($result, 'NoExel')),
                    "Jenis"           => trim(odbc_result($result, 'Jenis')),
                    "Kategori"        => trim(odbc_result($result, 'HeaderKategori')),
                    "Partid"          => trim(odbc_result($result, 'Partid')),
                    "Gambar"          => trim(odbc_result($result, 'Gambar')),
                    "UkuranKarton"    => trim(odbc_result($result, 'UkuranKarton')),
                    "RawMaterial"     => trim(odbc_result($result, 'RawMaterial')),
                    "Mekanik"         => trim(odbc_result($result, 'Mekanik')),
                    "Ukuran"          => trim(odbc_result($result, 'Ukuran')),
                    "Kapasitas"       => trim(odbc_result($result, 'Kapasitas')) . ' ' . trim(odbc_result($result, 'KapasitasUkuran')),
                    "Punggung"        => trim(odbc_result($result, 'Punggung')) . ' ' . trim(odbc_result($result, 'PunggungUkuran')),
                    "LabelPunggung"   => trim(odbc_result($result, 'LabelPunggung')),
                    "Fitur"           => trim(odbc_result($result, 'Fitur')),
                    "KodeWarna"       => trim(odbc_result($result, 'KodeWarna')) . ' ' . trim(odbc_result($result, 'WaranUkuran')),
                    "Video"           => trim(odbc_result($result, 'Video')),
                    "KapasitasUkuran" => trim(odbc_result($result, 'KapasitasUkuran')),
                    "PunggungUkuran"  => trim(odbc_result($result, 'PunggungUkuran')),
                    "WaranUkuran"     => trim(odbc_result($result, 'WaranUkuran')),
                ];
            }
        } else {
            $this->consol_war("Gagal menjalankan query: $query");
        }

        //$this->consol_war($datafull);
        // Kembalikan hasil
        return $datafull;
    }
}
?>
