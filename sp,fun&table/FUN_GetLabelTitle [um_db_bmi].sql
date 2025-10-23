USE [um_db_bmi]
GO

-- Cek dan hapus fungsi lama jika ada (kompatibel SQL Server 2000)
IF EXISTS (
    SELECT name 
    FROM sysobjects 
    WHERE id = OBJECT_ID(N'[dbo].[FUN_GetLabelTitle]') 
      AND xtype IN ('FN', 'IF', 'TF')
)
    DROP FUNCTION [dbo].[FUN_GetLabelTitle]
GO

CREATE FUNCTION [dbo].[FUN_GetLabelTitle]
(
    @kategory NVARCHAR(100)  -- input kategori
)
RETURNS NVARCHAR(3000)
AS
BEGIN
    DECLARE 
        @hasil NVARCHAR(3000),
        @rep_kategory NVARCHAR(100)

    -- Ubah tanda '-' jadi spasi
    SET @rep_kategory = REPLACE(@kategory, '-', ' ')

    -- Coba ambil data berdasarkan SubKategori terlebih dahulu
    SELECT TOP 1 @hasil = NamaMenu
    FROM MasterMenuKatalog
    WHERE SubKategori = @rep_kategory

    -- Jika hasil masih NULL atau kosong, cek berdasarkan HeaderKategori
    IF (@hasil IS NULL OR LTRIM(RTRIM(@hasil)) = '')
    BEGIN
        SELECT TOP 1 @hasil = NamaMenu
        FROM MasterMenuKatalog
        WHERE HeaderKategori = @rep_kategory
    END

    -- Jika tetap tidak ada hasil, isi default agar tidak NULL
    IF (@hasil IS NULL OR LTRIM(RTRIM(@hasil)) = '')
        SET @hasil = 'Tidak ditemukan'

    RETURN @hasil
END
GO

-- Tes fungsi
PRINT dbo.FUN_GetLabelTitle('PVC-LAF')

