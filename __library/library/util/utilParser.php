<?php
class utilParser extends Controller_Front
{
	function parseModule($sModule, $sBlock ,$sFile)
	{
		if(!in_array($sModule, $this->aModules))
			$this->aModules[] = $sModule;
		
		$this->sModule = $sModule;
		
		$this->initModule($sBlock);
		
		$sContents = file_get_contents($sFile);

		$aVar = $this->aVars;
		foreach($aVar as $index => $value)
		{
			if(preg_match_all('/\{\$' . preg_quote($index) . '}/', $sContents ,$bResult)){
				$sContents = preg_replace('/\{\$' . preg_quote($index) . '}/', $value, $sContents);
			}
		}
		
		echo $sContents;
	}
	
	function parseModuleCSS()
	{
		$sModuleCSS = '';
		if(is_array($this->aModules))
		{
			foreach($this->aModules as $index => $sModule)
			{
				if(is_array($this->aCSS[$sModule]))
				{
					foreach($this->aCSS[$sModule] as $key => $sCSS)
					{
						$file = FW_MODULES . DS . $sModule . DS . FW_MODULE_FRONT_CSS . DS . $sCSS . '.css';
						if(file_exists($file)){
							if(!strstr($sModuleCSS, file_get_contents($file)))
								$sModuleCSS .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"/resource.php?fetch=" . $sCSS . "&type=moduleCSS&module=" . $sModule . "&ext=css\">" . PHP_EOL;
						}
					}
				}
			}
		}
		
		return $sModuleCSS;
	}
	
	function parseModuleJS()
	{
		$sModuleJS = '';
		if(is_array($this->aModules))
		{
			foreach($this->aModules as $index => $sModule)
			{
				if(is_array($this->aJS[$sModule]))
				{
					foreach($this->aJS[$sModule] as $key => $sJS)
					{
						$file = FW_MODULES . DS . $sModule . DS . FW_MODULE_FRONT_JS . DS . $sJS . '.js';
						if(file_exists($file)){
							$sModuleJS .= "<script type=\"text/javascript\" src=\"/resource.php?fetch=" . $sJS . "&type=moduleJS&module=" . $sModule . "&ext=js\"></script>" . PHP_EOL;
						}
					}
				}
			}
		}
		
		return $sModuleJS;
	}
	
	function parseModuleExJS()
	{
		$sModuleExJS = '';
		if(is_array($this->aModules))
		{
			foreach($this->aModules as $index => $sModule)
			{
				if(is_array($this->aExJS[$sModule]))
				{
					foreach($this->aExJS[$sModule] as $key => $sJS)
					{
						$sModuleExJS .= "<script type=\"text/javascript\" src=\"" . $sJS . "\"></script>" . PHP_EOL;
					}
				}
			}
		}
		
		return $sModuleExJS;
	}
	
	public function initModule($sBlock)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . DS . 'modules' . DS . $this->sModule . DS . 'class' . DS . 'front/frontPage' . ucfirst($sBlock) . '.php';
		
		$sFrontController = 'frontPage' . $sBlock;
		$oFrontController = new $sFrontController();
		$this->initiateModule($oFrontController);
	}
}

$oParser = new utilParser();
?>