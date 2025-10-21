<?php
class ImportExcelKatalogModel extends Models
{
    private $table = "[um_db].[dbo].ProdukKatalog";
    private $table_sotemp = "[um_db].[dbo].gramediaso_temp";
    private $table_ms = "[bambi-bmi].[dbo].Sotransation_GMA";

    public function saveData()
    {
        $rawData = $_POST["data"];
        $post = json_decode($rawData, true);

        $IDimport = $post["idimport"];

        // Pastikan file diupload
        if (!isset($_FILES["files"]) || $_FILES["files"]["error"] !== 0) {
            return array(
                "status" => "error",
                "message" => "File tidak diupload atau error!"
            );
        }

        $tmp_file = $_FILES["files"]["tmp_name"];
      


        // Baca file Excel
        $reader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $reader->load($tmp_file);
        $sheet = $objPHPExcel->getActiveSheet();

     
        $rows = $sheet->toArray(null, true, true, true);
        $countRow = count($rows);
        $countNumber = 0;

        $header1 = isset($rows[8]) ? $rows[8] : null;
        $header2 = isset($rows[9]) ? $rows[9] : null;

        if(!$header1 || !$header2){
                return [
            "status" => "error",
            "message" => "❌ Header Excel tidak ditemukan di baris 8–9. Gunakan template yang benar."
            ];
        }
          $finalHeader = $this->combineExcelHeaders($header1, $header2);
          
        // ✅ Baris header aslinya di baris ke-2
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
              // --- Validasi header ---
    $checkHeader = $this->validateExcelHeader($finalHeader, $expectedHeaders);
    die(var_dump($checkHeader));
    if ($checkHeader["status"] === "error") return $checkHeader;


      
        // ✅ Cek kesesuaian setiap kolom header
        foreach ($expectedHeaders as $col => $expectedText) {

            $actualText = isset($headerRow[$col]) ? trim($headerRow[$col]) : '';
            if (strcasecmp($actualText, $expectedText) !== 0) {
                return array(
                    "status" => "error",
                    "message" => "❌ Format file Excel tidak sesuai di kolom {$col}. 
                                Ditemukan: '{$actualText}', seharusnya: '{$expectedText}'. 
                                Gunakan template Excel yang benar."
                );
            }
        }


        $expectedColumnCount = count($expectedHeaders);

        foreach ($rows as $index => $row) {
            $countNumber++;

            // Lewati baris header
            if ($index <= 3) continue;
            // Lewati baris terakhir kosong
            if ($countRow == $countNumber) continue;

            // ✅ Validasi jumlah kolom
            $currentColumnCount = count($row);
            if ($currentColumnCount < $expectedColumnCount) {
                return array(
                    "status" => "error",
                    "message" => "❌ Baris ke-{$countNumber} memiliki kolom kurang. 
                                Ditemukan {$currentColumnCount}, seharusnya {$expectedColumnCount}."
                );
            }

            // Ambil isi data
            $number         = trim($row["A"]);
            $product_number = trim($row["B"]);
            $all            = trim($row["C"]);
            $store          = trim($row["D"]);
            $item_tax       = trim($row["E"]);
            $price_list     = (float)$this->substring($row["F"]);
            $disc           = (float)$this->substring($row["G"]);
            $price_disc     = (float)$this->substring($row["H"]);
            $price          = $this->substring($row["I"]);
            $qty            = (int)$row["J"];
            $total_price    = (float)$this->substring($row["K"]);
            $payable        = (float)$this->substring($row["L"]);
            $ppn            = (float)$this->substring($row["M"]);

            // Cek kolom wajib
            $requiredFields = array(
                'A' => $number,
                'B' => $product_number,
                'C' => $all,
                'D' => $store,
                'J' => $qty,
                'K' => $total_price
            );

            $emptyCols = array();
            foreach ($requiredFields as $col => $val) {
                if ($val === '' || $val === null) {
                    $emptyCols[] = $col;
                }
            }

            if (!empty($emptyCols)) {
                $cols = implode(', ', $emptyCols);
                return array(
                    "status" => 'error',
                    "message" => "❌ Data kosong terdeteksi di baris ke-{$countNumber}, kolom: {$cols}. Harap lengkapi data sebelum upload."
                );
            }

            // Insert data
            
            $this->db->baca_sql($query);
        }

       
        // return array(
        //     "status" => 'berhasil',
        //     "message" => $datas,
        // );
    }

/**
 * Gabungkan dua baris header Excel (untuk merge cell)
 */
private function combineExcelHeaders($header1, $header2)
{
    $finalHeader = [];
    $lastMainHeader = '';

    foreach ($header1 as $col => $val1) {
        $val1 = trim($val1);
        $val2 = trim(isset($rows[2]) ? $rows[2] :'');

        // jika header utama kosong, pakai header terakhir (karena merge)
        if ($val1 === '') {
            $val1 = $lastMainHeader;
        } else {
            $lastMainHeader = $val1;
        }

        // gabung dua baris header
        $finalHeader[$col] = strtoupper($val2 ? "{$val1} | {$val2}" : $val1);
    }

  
    return $finalHeader;
}

/**
 * Validasi kesesuaian header Excel dengan template
 */
private function validateExcelHeader($actualHeader, $expectedHeaders)
{
    foreach ($expectedHeaders as $col => $expectedValue) {
        $actualValue = strtoupper(trim(isset($actualHeader[$col]) ?  $actualHeader[$col] :''));
        if ($actualValue !== strtoupper($expectedValue)) {
            return [
                "status" => "error",
                "message" => "❌ Format file tidak sesuai di kolom {$col}. 
                Ditemukan: '{$actualValue}', seharusnya: '{$expectedValue}'. 
                Gunakan template Excel yang benar."
            ];
        }
    }

    return ["status" => "ok"];
}

    private function substring($value)
    {
        $trimmed = $this->test_input($value);
        return str_replace(",", "", $trimmed);
    }



    public function ProsesData(){
        $rawData = file_get_contents("php://input");
            $post = json_decode($rawData, true);
            $username = $_SESSION['login_user'];
            $idimport = $this->test_input($post["idimport"]);
            $query=" EXEC USP_ProsesImportgramediaSO '{$idimport}','{$username}'";

            //$this->consol_war($query);
        $cek = 0;
        $result = $this->db->baca_sql($query);

        if (!$result) {
            $cek++;
        }

        if ($cek === 0) {
            $status = [
                'nilai' => 1,
                'error' => 'Data Berhasil'
            ];
        } else {
            $status = [
                'nilai' => 0,
                'error' => 'Data Gagal'
            ];
        }

        return $status;
    }
}
