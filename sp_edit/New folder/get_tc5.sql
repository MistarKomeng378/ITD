USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[get_tc5]    Script Date: 10/31/2019 19:05:36 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[get_tc5] 
	@tc5_id bigint,
	@trx_id bigint,
	@unix_no tinyint
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	declare @charges as money
	
	select top 1 @charges=tc5_charges from itd_param
	    
	if @unix_no=0
	begin
		SELECT     0 as no_unix,0 as tc5_id,trx_id,bank_acc_name beneficiary_name,bank_acc_no beneficiary_acc_no, trx_to beneficiary_bank, 
			trx_acc_no src_acc_no,trx_nominal amount,dbo.terbilang(trx_nominal) as amount_said,
			trx_acc_name as msg, 
			trx_acc_name+'|C/O Custodial Services ' as sender_name,
			@charges as charges, 0 as printed_status, '' as printed_by,null as printed_date,trx_valuta_date
			,trx_create_by as processor_id,pic_id,0 as tc5_no,trx_client_code
		FROM         itd_trx_approved
		where trx_id=@trx_id and trx_type=1 and trx_progress_status<>11
	end
	else
	begin
		SELECT     1 as no_unix,tc5_id, trx_id, beneficiary_name, beneficiary_acc_no, beneficiary_bank, src_acc_no, amount, amount_said, msg, sender_name, charges, 
						  printed_status, printed_by, printed_date,trx_valuta_date,processor_id,pic_id,tc5_no,trx_client_code
		FROM         itd_tc5
		where tc5_id=@tc5_id
	end
END

