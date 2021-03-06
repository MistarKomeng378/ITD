USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[list_tc5]    Script Date: 10/31/2019 19:03:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[list_tc5]
	@dt datetime,
	@trx_client_code varchar(20)='',
	@trx_to varchar(50)='',
	@bank_acc_name varchar(150)='' 
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	    
	SELECT     0 as no_unix,0 as tc5_id,trx_id,bank_acc_name beneficiary_name,bank_acc_no beneficiary_acc_no, trx_to beneficiary_bank, 
			trx_acc_no src_acc_no,trx_nominal amount,dbo.terbilang(trx_nominal) as amount_said,
			trx_acc_name as msg, 
			trx_acc_name+'|C/O Custodial Services ' as sender_name,
			30000 as charges, 0 as printed_status, '' as printed_by,null as printed_date,trx_valuta_date
			,trx_create_by as processor_id,pic_id,trx_client_code,nfs_td
	FROM         itd_trx_approved
	where 
	trx_valuta_date=@dt and trx_id not in(select trx_id from itd_tc5 where trx_valuta_date=@dt) and trx_type=1 and trx_progress_status<>11
	and
		(@trx_client_code='' or trx_client_code like '%'+@trx_client_code+'%')
	and
		(@trx_to='' or trx_to like '%'+@trx_to+'%')
	and
		(@bank_acc_name='' or bank_acc_name like '%'+@bank_acc_name+'%')
	union
	SELECT     1 as no_unix,tc5_id, trx_id, beneficiary_name, beneficiary_acc_no, beneficiary_bank, src_acc_no, amount, amount_said, msg, sender_name, charges, 
						  printed_status, printed_by, printed_date,trx_valuta_date,processor_id,pic_id,trx_client_code,nfs_td
	FROM         itd_tc5
	where trx_valuta_date=@dt 
	and
		(@trx_client_code='' or trx_client_code like '%'+@trx_client_code+'%')
	and
		(@trx_to='' or beneficiary_bank like '%'+@trx_to+'%')
	and
		(@bank_acc_name='' or beneficiary_name like '%'+@bank_acc_name+'%')
END
