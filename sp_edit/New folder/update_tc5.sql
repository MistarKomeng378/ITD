USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[update_tc5]    Script Date: 10/31/2019 19:00:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[update_tc5]
	@unix_no tinyint,
	@tc5_id [bigint] ,
	@trx_id [bigint],
	@beneficiary_name [varchar](255),
	@beneficiary_acc_no [varchar](25),
	@beneficiary_bank [varchar](100),
	@src_acc_no [varchar](25),
	@msg [varchar](255),
	@sender_name [varchar](255),
	@charges [money] ,
	@printed_by [varchar](20) 
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	
	declare @trx_valuta_date datetime
	declare @trx_create_by varchar(20)
	declare @pic_id int
	declare @amount money
	declare @amount_said varchar(255)
	declare @trx_client_code varchar(20)
	declare @nfs_td tinyint
	

	if @unix_no=0
	begin
		select @pic_id=pic_id,@trx_valuta_date=trx_valuta_date,@trx_create_by=trx_create_by,
			@amount=trx_nominal,@amount_said=dbo.terbilang(trx_nominal),@trx_client_code=trx_client_code,
			@nfs_td=nfs_td
		from itd_trx_approved where trx_id=@trx_id
		
		declare @tc5_no int
		select @tc5_no=count(tc5_id) from itd_tc5 where trx_valuta_date=@trx_valuta_date

		insert into itd_tc5(trx_id, trx_valuta_date, beneficiary_name, beneficiary_acc_no, 
			beneficiary_bank, src_acc_no, amount, amount_said, msg, sender_name, charges, printed_status, 
			printed_by, printed_date, processor_id, pic_id,tc5_no,trx_client_code,nfs_td)
		values(@trx_id,@trx_valuta_date,@beneficiary_name,@beneficiary_acc_no,@beneficiary_bank,
			@src_acc_no,@amount,@amount_said,@msg,@sender_name,@charges,1,@printed_by,
			getdate(),@trx_create_by,@pic_id,@tc5_no+1,@trx_client_code,@nfs_td)
	end
	else
	begin
		select @pic_id=pic_id
		from itd_tc5
		where tc5_id=@tc5_id

		insert into itd_tc5_hist(tc5_id, trx_id, trx_valuta_date, beneficiary_name, beneficiary_acc_no, beneficiary_bank, src_acc_no, amount, amount_said, msg, sender_name, 
                      charges, printed_status, printed_by, printed_date, processor_id, pic_id,tc5_no,trx_client_code,nfs_td)
		SELECT     tc5_id, trx_id, trx_valuta_date, beneficiary_name, beneficiary_acc_no, beneficiary_bank, src_acc_no, amount, amount_said, msg, sender_name, 
                      charges, printed_status, printed_by, printed_date, processor_id, pic_id,tc5_no,trx_client_code,nfs_td
		FROM         itd_tc5
		where tc5_id=@tc5_id
		
		select @pic_id=pic_id,@trx_valuta_date=trx_valuta_date,@trx_create_by=trx_create_by,
			@amount=trx_nominal,@amount_said=dbo.terbilang(trx_nominal),@trx_client_code=trx_client_code
		from itd_trx_approved where trx_id=@trx_id

		update itd_tc5
			set beneficiary_name=@beneficiary_name, beneficiary_acc_no=@beneficiary_acc_no, 
			beneficiary_bank=@beneficiary_bank, src_acc_no=@src_acc_no, msg=@msg, 
			sender_name=@sender_name, charges=@charges, amount=@amount, amount_said=@amount_said,
			printed_status=2, 
			printed_by=@printed_by, printed_date=getdate()
		where tc5_id=@tc5_id
	end

	--if @pic_id is not null
		update itd_pic set bank_rek=@beneficiary_acc_no,bank_name=@beneficiary_bank,bank_acc_name=@beneficiary_name
		where pic_id=@pic_id
	
	if @unix_no=0
		select top 1 tc5_id from itd_tc5 order by tc5_id desc
	else
		select @tc5_id  as tc5_id
    
END