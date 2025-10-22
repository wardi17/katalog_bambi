use [um_db_bmi]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE USP_TampilProdukKatalog
@Kategori  VARCHAR(100)
AS
BEGIN

	SET NOCOUNT ON;
    SELECT  NoExel,Partid,HeaderKategori AS Kategori,Jenis,Gambar,UkuranKarton,RawMaterial,Mekanik,Ukuran,Kapasitas,Punggung,LabelPunggung,Fitur, KodeWarna,Video
     FROM ProdukKatalog WHERE HeaderKategori = @Kategori
END
GO
EXEC USP_TampilProdukKatalog 'PVC LAC' 