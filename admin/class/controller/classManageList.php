<?php
class classManageList extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library("common");
	    $this->importJS("class/add_class_list");

	    if(isset($_SESSION['idx'])){
	        $this->absentStudentReady($aArgs);
        }
        else {
            echo "<script>location.href='" . BASE_URL . "admin/'</script>";
        }
    }

    private function absentStudentReady($aArgs)
    {
	    $aData['uid'] = isset($aArgs['uid']) ? $aArgs['uid'] : "";
	    $aData['cid'] = isset($aArgs['cid']) ? $aArgs['cid'] : "";
	    $aData['name'] = isset($aArgs['name']) ? $aArgs['name'] : "";
	    $aData['sdate'] = isset($aArgs['sdate']) ? $aArgs['sdate'] : "";
	    $aData['edate'] = isset($aArgs['edate']) ? $aArgs['edate'] : "";
	    $aData['class'] = isset($aArgs['class']) ? $aArgs['class'] : "";
	    $aData['teacher'] = isset($aArgs['teacher']) ? $aArgs['teacher'] : "";
	    $aData['branch'] = isset($aArgs['branch']) ? $aArgs['branch'] : "";
	    $aData['rows'] = isset($aArgs['rows']) ? $aArgs['rows'] : "";
	    $aData['view'] = isset($aArgs['view']) ? $aArgs['view'] : "";
	    $aData['page'] = isset($aArgs['page']) ? $aArgs['page'] : "";
	    $aData['vstat'] = isset($aArgs['vstat']) ? $aArgs['vstat'] : "";

	    /*Get Information*/
	    $sQueryEdit = 'SELECT DISTINCT c.idx AS main_idx, s.payment_method AS payment_method, u.idx AS user_id,
                    p.name AS classname, s.sale_status AS sale_status, p.total_months AS period, p.type AS classtype, p.teacher_type AS teachertype
                    FROM tb_user u, tb_class c, tb_product_class p, tb_sales_product s
                    WHERE c.p_class_idx = p.idx
                    AND c.student_idx = u.idx
                    AND s.class_idx = c.idx
                    AND s.user_idx = u.idx
                    AND s.product_idx = p.idx
                    AND c.idx = '.$aData['cid'].'';
	    $aData['classDetails'] = $this->query($sQueryEdit);
	    $this->display("class/tpl/classManageList", $aData);
    }
}
