<?php
class execmodel extends model
{
   /**
     * Execute custom query
     * @param String $sTable
     * @param String $sRow
     * @return Boolean, String, Array, Integer
     */

    public function execQuery($sQuery, $sRow = "row")
    {
        return $this->query($sQuery, $sRow);
    }

    /**
     * Delete data
     * @param String $sTable
     * @param String $sWhere
     * @return Boolean
     */

    public function deleteData($sTable, $sWhere)
    {
        $sSql = "DELETE FROM " . $sTable . " WHERE " . $sWhere;
        return $this->query($sSql);
    }

    /**
     * Upadate data
     * @param String $sTable
     * @param Array $aData
     * @param String $sWhere
     * @return Boolean
     */

    public function updateData($sTable, $aData, $sWhere = "")
    {
        return $this->update($sTable, $aData, $sWhere)->execute();
    }

    /**
     * Insert data
     * @param String $sTable
     * @param Array $aData
     * @return Boolean
     */

    public function insertData($sTable, $aData)
    {
        return $this->insert($sTable, $aData)->execute();
    }
}