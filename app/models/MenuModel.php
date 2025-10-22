<?php
class MenuModel extends Models {
  
  
  private  function numberToRoman($num)
{
       // Jika null atau bukan angka
    if ($num === null || $num === '' || !is_numeric($num)) {
        return null; // atau bisa juga return '' sesuai kebutuhanmu
    }
    // Pastikan input berupa angka dan dalam rentang yang valid
    $num = intval($num);
    if ($num <= 0 || $num > 3999) {
        return "Angka di luar jangkauan (1 - 3999)";
    }

    // Daftar simbol Romawi dan nilainya
    $romans = array(
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1
    );

    $result = '';

    // Loop dari besar ke kecil
    foreach ($romans as $roman => $value) {
        // Cek berapa kali simbol ini bisa digunakan
        $matches = intval($num / $value);
        $result .= str_repeat($roman, $matches);
        $num = $num % $value;
    }

    return $result;
}

private function numberToAlphabet($num)
{
       // Jika null atau bukan angka
    if ($num === null || $num === '' || !is_numeric($num)) {
        return null; // atau bisa juga return '' sesuai kebutuhanmu
    }
    // Pastikan input berupa angka positif
    $num = intval($num);
    if ($num <= 0) {
        return "Angka harus lebih besar dari 0";
    }

    $result = '';

    // Rumus konversi angka ke huruf (A-Z, AA, AB, dst)
    while ($num > 0) {
        $mod = ($num - 1) % 26;
        $result = chr(65 + $mod) . $result; // 65 = ASCII 'A'
        $num = intval(($num - $mod) / 26);
    }

    return $result;
}

    public function TampilMenu() {
        $query = "USP_TampilMenu";
      
        $result = $this->db->baca_sql2($query);

            $datafull =[];
            while(odbc_fetch_row($result)){
                $Romawi         =  $this->numberToRoman(rtrim(odbc_result($result,'Romawi')));
                $SubRomawi      = $this->numberToAlphabet(rtrim(odbc_result($result,'SubRomawi')));
                $NamaMenu       =  rtrim(odbc_result($result,'NamaMenu'));
                $HeaderKategori =  rtrim(odbc_result($result,'HeaderKategori'));
                $SubKategori    =  rtrim(odbc_result($result,'SubKategori'));
                $linkheader     =  rtrim(odbc_result($result,'linkheader'));
                $linkdetail     =  rtrim(odbc_result($result,'linkdetail'));
           

                
                $datafull[] =[
                    "Romawi"        =>$Romawi,
                    "SubRomawi"     =>$SubRomawi,
                    "NamaMenu"      =>$NamaMenu,
                    "HeaderKategori"=>$HeaderKategori,
                    "SubKategori"   =>$SubKategori,
                    "linkheader"    =>$linkheader,
                    "linkdetail"    =>$linkdetail

                ];

            }

      // $this->consol_war($datafull);
        return $datafull;   
        
    }
}