<?php

/**
* @author YongHun Jeong <yhjeong@simplexi.com>
* @version 1.1
*
* utilDbclass
*/

require_once ('utilSplClass.php');
require_once ('utilDbAdapter.php');
require_once ('utilDbDriverCommon.php');
require_once ('utilDbDriverInterface.php');
require_once ('utilDbDriverMysql.php');
require_once ('utilDbModel.php');
require_once ('utilDbUtility.php');

class Model extends utilDbModel
{
	private $str;
	private $sReturnRowType = '';
	
	/**
     * 트랜잭션 시작
     * @return Bool true|false
     */
    final public function transactionStart()
    {
        return $this->dbDriver->beginTransaction();
    }

    /**
     * 트랜잭션 커밋
     * @return Bool true|false
     */
    final public function transactionCommit()
    {
        return $this->dbDriver->commit();
    }

    /**
     * 트랜잭션 롤백
     * @return Bool true|false
     */
    final public function transactionRollback()
    {
        return $this->dbDriver->rollBack();
    }

 	/**
     * query 실행
     * PDO의 SQL Error가 발생할 경우 LOG를 남깁니다.
     * 사용법은 coreModel::query() 참조 하세요.
     *
     * @param Strig $sSql sql
     * @param String $sType row,rows,exec [?d]('?d / row?d / rows?d / exec?d' 사용하면 Debug Log가 기록 됩니다.)
     * @param Bool $bIsCache 캐쉬 여부
     */
    final public function query($sSql, $sType=null, $bIsCache=false)
    {
        $sSql = trim($sSql);
        $aType = parse_url($sType);
        $sType = ($aType['path']) ? $aType['path'] : null;

        if(is_null($sType) === true) $sType = $this->_getType($sSql);

        $mResult = parent::query($sSql, $sType);

        return $mResult;
    }

    /**
     * framework 에서 지원하는 상수 반환
     * @param unknown_type $sSql
     */
    private function _getType($sSql)
    {
        $sQueryType = $this->_getQueryType($sSql);

        switch ($sQueryType) {
            case 'select' :
                $sResult = UTIL_DB_RESULT_ROWS;
                break;
            default :
                $sResult = UTIL_DB_RESULT_EXEC;
                break;
        }

        return $sResult;
    }

    /**
     * Query 종류 반환
     * @param string $sSql 원본 Query 문자열
     * @return mixed SELECT, UPDATE, DELETE, INSERT 중 1 반환. 아무것도 해당되지 않으면 false 반환
     * */
    private function _getQueryType($sSql)
    {
        preg_match("/^\s*(SELECT|UPDATE|DELETE|INSERT)[\s]/i", $sSql, $aMatches);
        if (count($aMatches) > 1) return strtolower($aMatches[1]);
        else return false;
    }



	/**
	* generate sql insert statement.
	* Implementation: 
	*		$aData = array(
	*			'field1' => 'value1',
	*			'field2' => 'value2'			
	*		);
	*		$sql = utilDbQuery::getInsertQuery('table_name', $aData);
	*
	* @param string $table => table name
	* @param array $aData => data to be inserted
	* @return string result.
	*/
	public function getInsertQuery($table, $aData)
    {
        return $this->getInsertQueryLoop($table, array($aData));
    }
	
	/**
	* generate sql insert statement.
	* Implementation: 
	*		$aInsert[] = array('id' => '50', 'name' => 'boots');
	*		$aInsert[] = array('id' => '51', 'name' => 'arden');
	*		$aInsert[] = array('id' => '52', 'name' => 'sincere');
	*		$aInsert[] = array('id' => '53', 'name' => 'ardval');
	*		$sql = utilDbQuery::getInsertQueryLoop('table_name', $aInsert);
	*
	* @param string $table => table name
	* @param array $aData => data to be inserted
	* @return string result.
	*/
	public function insert($table, $aData)
    {
        if(!count($aData)) return false;

        $i = 0;
        $aInsert = array();
        $aField = array();
        foreach($aData as $sKey => $aValue) {

	        $aInsertData = array();
	        foreach($aValue as $field => $value)
	        {
	            if($i==0) $aField[] = $field;
	            $aInsertData[] = self::checkValue($value);
	        }
	        $aInsert[] = '('.implode(',', $aInsertData).')';
			$i++;
        }

		$this->str	= "INSERT INTO ".$table." (".implode(',', $aField).") VALUES ".implode(',', $aInsert);		
        return $this;
    }

	/**
	* generate sql insert statement.
	* Implementation: 
	*		$aUpdate = array(
	*			'name' => 'updated'
	*		);
	*		$sWhere = "id = '52'";
	*		$sql = utilDbQuery::getUpdateQuery($sTable, $aUpdate, $sWhere);
	*
	* @param string $table => table name
	* @param array $aData => data to be updated
	* @param string $sWhere(optional) => string condition
	* @return string result.
	*/
	public function getUpdateQuery($table, $aData, $sWhere="")
    {
        $str = "";
        if(!count($aData)) return false;

        foreach($aData as $field => $value)
        {
            $str .= $field." = ".$this->checkValue($value).",";
        }
        return "UPDATE ".$table." SET ".substr($str, 0, -1)." ".($sWhere ? " WHERE ".$sWhere : "");
    }

	
	private function checkValue($value){

        if($value == "null" || strtolower($value) == "now()")
		{
            return $value;
        }
		
        switch (strtolower(gettype($value)))
		{
            case 'string':
                settype($value, 'string');
                $value = "'".mysql_escape_string($value)."'";
                break;
            
			case 'integer':
                settype($value, 'integer');
                break;
            case 'double' :
            
			case 'float' :
                settype($value, 'float');
                break;
            
			case 'boolean':
                settype($value, 'boolean');
                break;
            
			case 'array':
                $value = "'".mysql_escape_string(implode(',', $value))."'";
                break;
            
			case 'null' :
                $value = 'null';
                break;
        
		}
        return $value;
    }

	final public function sys_query($sSql, $sType=null)
    {
        $mResult = $this->dbDriver->query($sSql, $sType);

        return $mResult;
    }
	
	/**
     * Select Function
     * @example $sql->select('mytable',array('first_name','last_name'),' where idx = 1')
     * @return Bool array
     */	
	final public function select( $sTblName , $aTblFields = NULL , $sWhereClause = NULL )
	{
		$sSql = "";
		$sFrom = " FROM " . $sTblName;
		$sFields = "";
		
		if( !$sTblName )
		{
			return FALSE;
		}
		
		$sSelect = $this->_fieldsClauseBuilder($aTblFields);		
		
		$sWhere = $this->_whereClauseBuilder($sWhereClause);
		
		$this->str = $sSelect . $sFrom . $sWhere;
		
		$this->sReturnRowType= 'rows';

		return $this;
	}
	
	final public function select1( $sTblName , $aTblFields = NULL , $sWhereClause = NULL )
	{
		$sSql = "";
		$sFrom = " FROM " . $sTblName;
		$sFields = "";
		
		if( !$sTblName )
		{
			return FALSE;
		}
		
		$sSelect = $this->_fieldsClauseBuilder($aTblFields);		
		
		$sWhere = $this->_whereClauseBuilder($sWhereClause);
		
		$this->str = $sSelect . $sFrom . $sWhere;
		
		$this->sReturnRowType= 'rows';

		return $this;
	}	
	
	final public function limit( $iLimit , $iOffset )
	{
		
		$this->str = $this->str . " LIMIT {$iLimit}, {$iOffset} ";
		return $this;
	}
	
	final public function orderBy( $sField , $sSortType )
	{
		$this->str = $this->str . " ORDER BY {$sField} " . strtoupper($sSortType);
		return $this;
	}	
	
	/**
     * Select All Function
     * @example $sql->selectAll('mytable')
     * @return Bool array
     */		
	final public function selectAll( $sTblName,$aTblFields = NULL )
	{
		$sSql = "";
		$sFrom = " FROM " . $sTblName;
		
		if( !$sTblName )
		{
			return FALSE;
		}
		$sSelect = $this->_fieldsClauseBuilder( $aTblFields );
		$this->str = $sSelect . $sFrom;
		$this->sReturnRowType= 'rows';
		return $this;
	}	
	
	/**
     * Select Row Function
     * @example $sql->selectRow('mytable',array('first_name','last_name'),' where idx = 1')
     * @return Bool array
     */	
	final public function selectRow( $sTblName , $aTblFields = NULL , $sWhereClause = NULL )
	{
		$sSql = "";
		$sFrom = " FROM " . $sTblName;

		if( !$sTblName )
		{
			return FALSE;
		}
		
		$sSelect = $this->_fieldsClauseBuilder( $aTblFields );
		
		$sWhere = $this->_whereClauseBuilder( $sWhereClause );
		
		$this->str = $sSelect . $sFrom . $sWhere;
		
		$this->sReturnRowType= 'row';
		
		return $this;
	}	

	
	/**
     * Where Clause Generator for where
     * @example where idx = 1 AND is_sequence = TRUE
     * @return Bool string
     */		
	private function _whereClauseBuilder($sWhereClause)
	{
		return ( $sWhereClause ) ? " WHERE $sWhereClause " : " ";
	}

	/**
     * Field Clause Generator for database table fields
     * @example title,location,start_date,end_date
     * @return Bool string
     */	
	private function _fieldsClauseBuilder($aSTblFields)
	{
		$sFields = "";
		
		if( $aSTblFields && is_array( $aSTblFields ) )
		{
			$sFields = implode( ' , ' , $aSTblFields );
		}
		
		if(is_string($aSTblFields) && !is_null($aSTblFields))
		{
			$sFields = $aSTblFields;
		}
		
		return " SELECT " . ( ( $sFields ) ? $sFields : " * "  );
	}
	
	// Delete all selected records
	final public function deleteAll($sTbl)
	{
		if(!$sTbl) return false;
		$this->str	= 'TRUNCATE ' . $sTbl;
		return $this;
	}
	
	
	// Delete selected records
	final public function deleteBy($sTbl, $sWhere)
	{
		if(!$sTbl || !$sWhere) return false;

		$this->str	= 'DELETE FROM '.$sTbl.' WHERE '.$sWhere;
		return $this;
	}


	// Update selected records
	public function update($table, $aData, $sWhere="")
	{
		$str = "";
		if(!count($aData)) return false;

		foreach($aData as $field => $value)
		{
			$str .= $field." = ".$this->checkValue($value).",";
		}
		
		$this->str	= "UPDATE ".$table." SET ".substr($str, 0, -1)." ".($sWhere ? " WHERE ".$sWhere : "");
		
		return $this; 
	}

	
	// Debug method chain
	final public function vs()
	{	
		echo $this->str;
	}	
	
	// Execute method chain
	final public function execute()
	{	
		switch($this->sReturnRowType)
		{
			case'rows':
				return $this->query($this->str,'rows');
			break;

			case'row':
				return $this->query($this->str,'row');
			break;
			
			default:	
				return $this->query($this->str);
		}
	}	
}