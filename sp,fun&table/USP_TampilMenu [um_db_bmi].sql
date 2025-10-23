use [um_db_bmi]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE USP_TampilMenu

AS
BEGIN

	SET NOCOUNT ON;
	IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#templinkhider') 
    BEGIN
      DROP TABLE #templinkhider;
    END;
    
    IF EXISTS(SELECT [Table_name] FROM tempdb.information_schema.tables WHERE [Table_name] like '#templinkdetail') 
    BEGIN
      DROP TABLE #templinkdetail;
    END;
	
	CREATE TABLE #templinkhider(
	 HeaderKategori NVARCHAR(100) NULL
	 )
	 
	 CREATE TABLE #templinkdetail(
	 SubKategori NVARCHAR(100) NULL
	 )
	 
	 BEGIN
		INSERT INTO #templinkhider
		SELECT DISTINCT HeaderKategori FROM ProdukKatalog
		
		INSERT INTO #templinkdetail
		SELECT DISTINCT SubKategori FROM ProdukKatalog
       
     END
      
     select A.Romawi,A.SubRomawi,A.NamaMenu,A.HeaderKategori,A.SubKategori,B.HeaderKategori AS linkheader ,C.SubKategori AS linkdetail 
     FROM  MasterMenuKatalog AS A
     LEFT JOIN #templinkhider  AS B
     ON B.HeaderKategori = A.HeaderKategori
     LEFT JOIN #templinkdetail  AS C
     ON C.SubKategori = A.SubKategori  ORDER BY A.Romawi,A.SubRomawi
    
END
GO
EXEC USP_TampilMenu