<?php
class adminPagePollList extends Controller_Admin
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sFormScript = usbuilder()->getFormAction('pollwidget_settings', 'adminExecPollSettings');
        $this->writeJs($sFormScript);
        usbuilder()->validator(array('form' => 'pollwidget_settings'));

        $iRowsPerPage = 10;
        $iPage = $aArgs['page'] ? $aArgs['page'] : 1;
        $aOption['row_limit'] = $iRowsPerPage;
        $aOption['start'] = $iRowsPerPage * ($iPage - 1);
        $aOption['sort'] = $aArgs['sort'] ? $aArgs['sort'] : 'desc';
        $aOption['sortby'] = $aArgs['sortby'] ? $aArgs['sortby'] : 'idx';
        $aOption['search'] = $aArgs['search'] ? $aArgs['search'] : '';
        $aOption['s'] = $aArgs['s'] ? $aArgs['s'] : '';
        $aOption['e'] = $aArgs['e'] ? $aArgs['e'] : '';
        $aOption['status'] = $aArgs['status'] ? $aArgs['status'] : '';
        $this->writeJs("$('#keyword').val('".$aOption['search']."');");
        $this->writeJs("$('#start').val('".$aOption['s']."');");
        $this->writeJs("$('#end').val('".$aOption['e']."');");

        $oModelPollAdmin = new modelPollAdmin();
        $iCountDone = $oModelPollAdmin->setDeleteFinishedPolls();
        $aContents = $oModelPollAdmin->getPolls($aOption);
        $sSettings = $oModelPollAdmin->getSettings();

        $iCount = $oModelPollAdmin->getPollCount($aOption);
        $iCountAll = $oModelPollAdmin->getPollCountByDate('All');
        $iCountWaiting = $oModelPollAdmin->getPollCountByDate('Waiting');
        $iCountOngoing = $oModelPollAdmin->getPollCountByDate('OnGoing');
        $iCountDone = $oModelPollAdmin->getPollCountByDate('Done');

        $iStartCount = ($iPage - 1) * $iRowsPerPage;
        //$iStartCount = $iStartCount == 0 ? 0 : $iStartCount;
        $iNum = $iCount - $iStartCount;

        $sSort = !$aArgs['sort'] || $aArgs['sort'] == '' || $aArgs['sort'] == 'asc' ? 'desc' : 'asc';
        $sPeriodClass = $aArgs['sortby'] == 'period_start' && $aArgs['sort'] == 'desc' ? 'des' : 'asc';
        $sRegDateClass = $aArgs['sortby'] == 'reg_date' && $aArgs['sort'] == 'desc' ? 'des' : 'asc';
        $sNumQstnClass = $aArgs['sortby'] == 'num_qstn' && $aArgs['sort'] == 'desc' ? 'des' : 'asc';
        $sNumRplyClass = $aArgs['sortby'] == 'num_rply' && $aArgs['sort'] == 'desc' ? 'des' : 'asc';

        $sPage = $aArgs['page'] ? "&page=".$aArgs['page'] : '';
        $sSearch = $aArgs['search'] ? "&search=".$aArgs['search'] : '';

        $this->assign('sUrl', usbuilder()->getUrl('adminPagePollList'));
        $this->assign('sUrledit', usbuilder()->getUrl('adminPagePollEdit'));
        $this->assign('sUrlresult', usbuilder()->getUrl('adminPagePollResult'));
        $this->assign('sPage', $sPage);
        $this->assign('sSearch', $sSearch);
        $this->assign('sPagination', usbuilder()->pagination($iCount, $iRowsPerPage));
        $this->assign('aContents', $aContents);
        $this->assign('iStartCount', $iNum);
        $this->assign('iPage', $iPage);
        $this->assign('sSort', $sSort);
        $this->assign('sPeriodClass', $sPeriodClass);
        $this->assign('sRegDateClass', $sRegDateClass);
        $this->assign('sNumQstnClass', $sNumQstnClass);
        $this->assign('sNumRplyClass', $sNumRplyClass);
        $this->assign('iCountAll', $iCountAll);
        $this->assign('iCountWaiting', $iCountWaiting);
        $this->assign('iCountOnGoing', $iCountOngoing);
        $this->assign('iCountDone', $iCountDone);
        $this->assign('sSettings', $sSettings);

        $this->importCSS('jqueryCalendar');
        $this->importJS('jqueryCalendar');
    	$this->importJS(__CLASS__);
    	$this->importCSS('common');
    	$this->importCSS('style');

    	$this->view(__CLASS__);
    }
}
?>