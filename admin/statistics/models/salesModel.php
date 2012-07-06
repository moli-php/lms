<?php
if( !defined('DIRECT_ACCESS') ) exit("No Direct Access!");

class salesModel extends Simplexi_controller
{
	private $SALES_PRODUCT = 'tb_sales_product';
	private $USER = 'tb_user';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getContents($sStartDate,$sEndDate,$iUserIdx)
	{
		$sSql = "			
			SELECT 
			branch_idx AS bidx,
			DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d') AS datetime_purchase,
			DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d') AS udatetime_purchase,
			(SELECT SUM(amount)) AS amount,
			(SELECT COUNT(*) FROM tb_sales_product WHERE DATE_FORMAT(FROM_UNIXTIME(tb_sales_product.datetime_purchase),'%Y-%m-%d') = udatetime_purchase AND branch_idx = bidx ) AS apply_count,
			(SELECT IFNULL(SUM(amount),0.00) FROM tb_sales_product WHERE tb_sales_product.payment_method = 'cash' AND sale_status = 'confirmed' AND DATE_FORMAT(FROM_UNIXTIME(tb_sales_product.datetime_purchase),'%Y-%m-%d') = udatetime_purchase AND branch_idx = bidx ) AS payment_cash,
			(SELECT IFNULL(SUM(amount),0.00) FROM tb_sales_product WHERE tb_sales_product.payment_method = 'card' AND sale_status = 'confirmed' AND DATE_FORMAT(FROM_UNIXTIME(tb_sales_product.datetime_purchase),'%Y-%m-%d') = udatetime_purchase AND branch_idx = bidx ) AS payment_card,
			(SELECT IFNULL(SUM(amount),0.00) FROM tb_sales_product WHERE sale_status = 'not_confirmed' AND DATE_FORMAT(FROM_UNIXTIME(tb_sales_product.datetime_purchase),'%Y-%m-%d') = udatetime_purchase AND branch_idx = bidx ) AS notconfirmed_payment,

			(SELECT COUNT(*) FROM tb_sales_product WHERE tb_sales_product.sale_status = 'not_confirmed' AND DATE_FORMAT(FROM_UNIXTIME(tb_sales_product.datetime_purchase),'%Y-%m-%d') = udatetime_purchase AND branch_idx = bidx ) AS not_confirmed,
			(SELECT COUNT(*) FROM tb_sales_product WHERE tb_sales_product.sale_status = 'confirmed' AND DATE_FORMAT(FROM_UNIXTIME(tb_sales_product.datetime_purchase),'%Y-%m-%d') = udatetime_purchase AND branch_idx = bidx ) AS confirmed
			FROM tb_sales_product WHERE branch_idx = '".$iUserIdx."' AND DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}' GROUP BY DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d')
		";
		
		return $this->query($sSql);
	}
	
	public function getProduct($sStartDate,$sEndDate,$iUserIdx)
	{
		$sSql = "
			SELECT 
			tp.branch_idx  AS bidx,
			tp.product_idx  AS pidx,
			tc.name AS class_name,
			tc.teacher_type AS teacher_type,
			tc.price AS price,
			(SELECT  IFNULL(SUM(amount),0.00) FROM tb_sales_product WHERE sale_status = 'confirmed' AND payment_method = 'cash' AND branch_idx = bidx AND product_idx = pidx ) AS income,
			(SELECT COUNT(*) FROM tb_sales_product WHERE branch_idx = bidx AND product_idx = pidx AND DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}') AS total_applied			
			FROM tb_sales_product AS tp INNER JOIN tb_product_class AS tc ON tc.idx = tp.product_idx WHERE tp.branch_idx = {$iUserIdx}
			AND DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}'
			GROUP BY product_idx	
		";				
		
		return $this->query($sSql);
	}
	
	public function getBranch()
	{
		return $this->select($this->USER,'','grade_idx = 8')->execute();
	}
}