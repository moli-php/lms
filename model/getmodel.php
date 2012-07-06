<?php

class getmodel extends model
{
	/**
     * Get data
     * @param String $sTable
     * @param Array $aData
     * @param String $sRow
     * @return Array
     */

    public function getData($sTable, $aData = array(), $sRow = "rows")
    {
       $sSql = "SELECT * FROM " . $sTable;

       if (isset($aData['where']) && $aData['where'] != ""){
           $sWhere = " WHERE ";

           if (is_array($aData['where'])){
               foreach ($aData['where'] as $sField => $sValue)
                   $sWhere .= ($sWhere != " WHERE " ? " AND " : "") . $sField . " = " . $this->checkValue($sValue);

               $sSql .= $sWhere;
           }
           else $sSql .= $sWhere . $aData['where'];
       }

       if (isset($aData['order']) && $aData['order'] != "" && !isset($aData['sort']))
           $sSql .= " ORDER BY " . $aData['order'];
       else if (isset($aData['order']) && $aData['order'] && isset($aData['sort']) && $aData['sort'] != "")
           $sSql .= " ORDER BY " . $aData['order'] . " " . strtoupper($aData['sort']);

       if (isset($aData['limit']) && isset($aData['offset']) && (int) $aData['limit'] != 0 && (int) $aData['offset'] != 0)
           $sSql .= " LIMIT " . $aData['offset'] . ", " . $aData['limit'];

       else if (isset($aData['limit']) && $aData['limit'] != "")
           $sSql .= " LIMIT " . $aData['limit'];

       if (isset($aData['select']) && $aData['select'] != "")
           $sSql = str_replace("*", $aData['select'], $sSql);

       return $this->query($sSql, $sRow);
    }

    /**
     * Get Query
     * @param String $sSql
     * @param String $sRow
     * @return Array
     */

    public function getQuery($sSql, $sRow = "rows")
    {
        return $this->query($sSql, $sRow);
    }

    /**
     * Get row count
     * @param Integer $iSequence
     * @param String $sTable
     * @param String $sWhere
     * @return Interger
     */

    public function getTotalRows($sTable, $sWhere = null)
    {
        if ($sWhere != null)
            $sWhere = " WHERE " . $sWhere;

        $aResult = $this->query("SELECT COUNT(*) as rows FROM " . $sTable . $sWhere, "row");

        return $aResult['rows'];
    }

    public function getIdx($sTable)
    {
        $aResult = $this->query("SELECT MAX(idx) as maxidx FROM " . $sTable, "row");

        return $aResult['maxidx'];
    }

	private function checkValue($sValue)
    {
        if($sValue == "null" || strtolower($sValue) == "now()"){
            return $sValue;
        }
        switch (strtolower(gettype($sValue))){
            case 'string':
                settype($sValue, 'string');
                $sValue = "'" .  addslashes($sValue) . "'";
                break;
            case 'integer':
                settype($sValue, 'integer');
                break;
            case 'double' :
            case 'float' :
                settype($sValue, 'float');
                break;
            case 'boolean':
                settype($sValue, 'boolean');
                break;
            case 'array':
                $sValue = "'" .  addslashes(implode(',', $sValue)) . "'";
                break;
            case 'null' :
                $sValue = 'null';
                break;
        }
        return $sValue;
    }
}

?>