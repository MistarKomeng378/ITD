USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[get_trx]    Script Date: 11/21/2019 15:54:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER  procedure [dbo].[get_trx] 
	@user_id as varchar(20),
	@trx_id as int,
	@trx_unix as int
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	declare @lvl int
	--set @lvl = dbo.get_user_lvl(@user_id)
	
	--if @lvl<=5
	--begin
		if @trx_unix =1
		begin
			select itd_trx_unapproved.*,itd_trx_type.type_desc, cast(trx_type as varchar(2)) + cast(trx_deposit_type as varchar(2))+cast(trx_validation_key as varchar(2)) as val_key,month(trx_due_date)-month(trx_valuta_date) as bulan,
				type_desc , '' as bilyet_no, '' as bilyet_desc,bank_acc_no,bank_acc_name,coalesce(trx_rate_break,0) trx_rate_break
			from 
			(
			select * from itd_trx_unapproved where trx_id=@trx_id
			) itd_trx_unapproved left outer join itd_trx_type on itd_trx_unapproved.trx_type=itd_trx_type.type_id
			
		end
		else
		begin
			select itd_trx_approved.trx_id, trx_id_unapproved, trx_id_master, trx_id_upper, trx_to, trx_remark1, trx_up, trx_from, trx_telp, trx_fax, trx_from_fax, trx_ref, trx_date, 
                      trx_client_id, trx_client_code, trx_client_name as trx_client_name1,
                      case 
						when ltrim(rtrim(client_name))='' or client_name is null then trx_client_name else client_name end as trx_client_name, trx_acc_no, 
                      trx_acc_name as trx_acc_name1, case when ltrim(rtrim(acc_name))='' or acc_name is null then trx_acc_name else acc_name end as trx_acc_name, trx_bank_name, trx_type, trx_deposit_type, trx_deposit_tenor, 
                      trx_deposit_tenor_hr, trx_deposit_tenor_bln, trx_valuta_date, trx_due_date, trx_tax_status, trx_rate_payment, trx_nominal, trx_rate, 
                      trx_due_date_type, trx_validation_key, trx_create_dt, trx_create_by, trx_modified_dt, trx_progress_status, trx_progress_by, trx_other, 
                      trx_revise_note, trx_approved_dt, trx_approved_by, trx_break_dt, trx_curr, trx_bilyet_flag_no, trx_child_status
					,itd_trx_type.type_desc, cast(trx_type as varchar(2)) + cast(trx_deposit_type as varchar(2))+cast(trx_validation_key as varchar(2)) as val_key ,month(trx_due_date)-month(trx_valuta_date) as bulan,
				type_desc,
				case 
					when itd_bilyet_in.trx_id is not null then  itd_bilyet_in.bilyet_no
					when itd_bilyet_out.trx_id is not null then  itd_bilyet_out.bilyet_no
					else ''
				end bilyet_no,
				case 
					when itd_bilyet_in.trx_id is not null then  'Bilyet Masuk'
					when itd_bilyet_out.trx_id is not null then  'Bilyet Keluar'
					else ''
				end bilyet_desc
				,bank_acc_no,bank_acc_name,pic_id,coalesce(trx_rate_break,0) trx_rate_break, nfs_td
			from 
			(
			select * from itd_trx_approved where itd_trx_approved.trx_id=@trx_id
			) itd_trx_approved left outer join itd_trx_type on itd_trx_approved.trx_type=itd_trx_type.type_id
			left outer join itd_bilyet_in on itd_trx_approved.trx_id=itd_bilyet_in.trx_id
			left outer join itd_bilyet_out on itd_trx_approved.trx_id=itd_bilyet_out.trx_id
			left outer join  itd_client on itd_trx_approved.trx_client_id=itd_client.client_id
			
		end
	--end
	--else
	--begin
	--	if @trx_unix =1
	--	begin
	--		select itd_trx_unapproved.*,cast(trx_type as varchar(2)) + cast(trx_deposit_type as varchar(2))+cast(trx_validation_key as varchar(2)) as val_key ,month(trx_due_date)-month(trx_valuta_date) as bulan,
	--		type_desc 
	--		from itd_trx_unapproved left outer join itd_trx_type on itd_trx_unapproved.trx_type=itd_trx_type.type_id
	--		where trx_id=@trx_id and trx_create_by=@user_id
	--	end
	--	else
	--	begin
	--		select itd_trx_approved.*,cast(trx_type as varchar(2)) + cast(trx_deposit_type as varchar(2))+cast(trx_validation_key as varchar(2)) as val_key ,month(trx_due_date)-month(trx_valuta_date) as bulan,
	--		type_desc 
	--		from itd_trx_approved left outer join itd_trx_type on itd_trx_approved.trx_type=itd_trx_type.type_id
	--		where trx_id=@trx_id and trx_create_by=@user_id
	--	end
	--end
END