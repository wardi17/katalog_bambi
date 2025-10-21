<?php

class MsWarnaModel extends Models{
    private $table = '[um_db_bmi].[dbo].MasterWarna';

    public function getwarna($kategori)
    {
        $query = "SELECT KodeWarna, NamaWarna,HexCode FROM $this->table";
       $result = $this->db->baca_sql2($query);
            $datafull =[];
            while(odbc_fetch_row($result)){
                $datafull[] =[
                    "KodeWarna"=>rtrim(odbc_result($result,'KodeWarna')),
                    "NamaWarna"=>rtrim(odbc_result($result,'NamaWarna')),
                    "HexCode"=>rtrim(odbc_result($result,'HexCode')),
                ];

            }
            // $this->consol_war($datafull);

            return $datafull;
        }
}