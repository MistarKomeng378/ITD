USE [cs_jasa_giro]
GO
/****** Object:  StoredProcedure [dbo].[list_coa]    Script Date: 11/21/2019 13:16:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================

ALTER PROCEDURE [dbo].[list_coa]
	
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	--select * from coa where coa_no<>'C001'
	 select * from coa
	order by coa_no
END
