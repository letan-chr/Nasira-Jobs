-- AddPaymentStatusFieldToTransactionsTable: 
alter table `transactions` add `status` int not null default '1' after `amount`;
-- AddIsApprovedToTransactionsTable: 
alter table `transactions` add `is_approved` int not null default '1' after `status`;

