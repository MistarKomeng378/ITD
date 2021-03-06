USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[list_trx_due]    Script Date: 11/20/2019 10:32:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [dbo].[list_trx_due]
	@due_date datetime,
	@lte tinyint=0,
	-- Edit Kurob
	@end_date datetime=null
as
begin
	set nocount on
	select a.*,b.type_desc,c.payment_desc
	from
	(
		select trx_id,trx_valuta_date,trx_due_date,trx_to,trx_client_name,trx_nominal,trx_rate
			,trx_create_dt,trx_create_by,trx_type,trx_client_code,trx_rate_payment
		from itd_trx_approved
		where trx_id not in (select trx_id_upper from itd_trx_approved)
		and trx_type in(1,2) and trx_deposit_type in(1,2) and trx_progress_status in(2,3,10)
		and 
		(
			(@lte=0 and trx_due_date=@due_date)
			or
			(@lte=1 and trx_due_date<=@due_date)
			or
			-- Edit Kurob
			(@lte=2 and trx_due_date>=@due_date and trx_due_date<=@end_date)
		)
	) a left join itd_trx_type b on a.trx_type=b.type_id
	left outer join itd_rate_payment c on a.trx_rate_payment=c.payment_id
	
	order by trx_due_date desc,trx_client_code,trx_client_name,trx_to desc
end