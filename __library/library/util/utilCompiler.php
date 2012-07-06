<?php
class utilCompiler extends utilParser 
{
	public $aModules = array();

	function compile()
	{
		/*
		if(Compiler::checkLayout(file_get_contents(REQUESTED_URI))) 
		{
			$sLayout = Compiler::compileLayout(file_get_contents(REQUESTED_URI));
			$sCompiled = Compiler::compileContent($sLayout, file_get_contents(REQUESTED_URI));
			$sCompiled = Compiler::compileImport($sCompiled);
		}
		else $sCompiled = Compiler::compileImport(file_get_contents(REQUESTED_URI));
		
		$sCompiled = Compiler::compileCSS($sCompiled);
		$sCompiled = Compiler::compileJS($sCompiled);
		*/
		
		$sCompiledPage = $this->compiledPage();

		return $sCompiledPage;
	}
	
	private function compiledPage()
	{
		$sCompiledPage = $this->compileMODULES();
		$sCompiledPage = $this->compileCSS($sCompiledPage);
		$sCompiledPage = $this->compileJS($sCompiledPage);
		
		return $sCompiledPage;
	}
	
	private function compileMODULES()
	{
		$sContents = '';

		$handle = fopen(REQUESTED_PAGE, "r") or die("Couldn't get handle");
		if ($handle) {
			while (!feof($handle)) {
				$sData = fgets($handle);
				if(preg_match("/<!--@module\(.*\)-->/imsx", $sData)){
					$openTag = explode("<!--@module(", $sData);
					$closeTag = explode(")-->", $openTag[1]);
					$aModuleBlock = explode('->', $closeTag[0]);
					$sModule = strtolower($aModuleBlock[0]);
					$this->aModule[] = $sModule;
					$sBlock = strtolower($aModuleBlock[1]);
					$sFile = FW_USER_FILES . DS . '_module' . DS . $sModule . DS . $sBlock . '.html';
					if(file_exists($sFile)){
						$sModuleContent = $this->parseModule($sModule, $sBlock, $sFile);
						$sContents .= preg_replace("/<!--@module\(" . preg_quote($closeTag[0], "/") . "\)-->/", $sModuleContent, $sData) . PHP_EOL;
					}
					else $sContents .= $sData . PHP_EOL;
				}
				else $sContents .= $sData;
			}
			fclose($handle);
		}
		
		return $sContents;
	}

	
/*		
	private function checkLayout($sContents)
	{
		if(preg_match("/<!--@layout\(.*\)-->/imsx", $sContents)){
			$openTag = explode("<!--@layout(", $sData);
			$closeTag = explode(")-->", $openTag[1]);
			$file = FW_PUBLIC . $closeTag[0];
			if(file_exists($file)){
				return true;
			}
		}
		
		return false;
	}
	
	private function compileLayout($sContents)
	{
		$sLines = explode("\n", $sContents); 
		foreach($sLines as $iLine => $sData) { 
			if(preg_match("/<!--@layout\(.*\)-->/imsx", $sData)){
				$openTag = explode("<!--@layout(", $sData);
				$closeTag = explode(")-->", $openTag[1]);
				$file = FW_PUBLIC . $closeTag[0];
				if(file_exists($file)){
					return file_get_contents($file);
				}
			}
		}
		
		return '';
	}

	private function compileContent($sLayout, $sContents)
	{
		if(preg_match("/<!--@contents-->/imsx", $sLayout))
		{
			$sContents = preg_replace("/<!--@layout\(.*\)-->/", '', $sContents);
			$sContents = preg_replace("/<!--@contents-->/", $sContents, $sLayout);
		}
		
		return $sContents;
	}
	
	private function compileImport($sContents)
	{
		$sLines = explode("\n", $sContents); 
		foreach($sLines as $iLine => $sData) { 
			if(preg_match("/<!--@import\(.*\)-->/imsx", $sData)){
				$openTag = explode("<!--@import(", $sData);
				$closeTag = explode(")-->", $openTag[1]);
				$file = FW_PUBLIC . $closeTag[0];
				if(file_exists($file)){
					$sContent = file_get_contents($file);
					$sContents = preg_replace("/<!--@import\(" . preg_quote($closeTag[0], "/") . "\)-->/", $sContent, $sContents);
				}
			}
		}
		
		return $sContents;
	}
*/	
	private function compileCSS($sHTML)
	{
		$sContents = '';
		$sLines = explode("\n", $sHTML); 
		foreach($sLines as $iLine => $sData) { 
			if(preg_match("/<!--@importCSS\(.*\)-->/imsx", $sData)){
				$openTag = explode("<!--@importCSS(", $sData);
				$closeTag = explode(")-->", $openTag[1]);
				$file = FW_USER_FILES . DS . 'css' . DS . $closeTag[0] . '.css';
				if(file_exists($file)){
					$sContent = "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"/css/" . $closeTag[0] . ".css\">";
					$sData = preg_replace("/<!--@importCSS\(" . preg_quote($closeTag[0], "/") . "\)-->/", $sContent, $sData);
				}
			}
			
			$sContent = $this->parseModuleCSS();
			$sContents .= preg_replace("/<!--@moduleCSS\(\)-->/", $sContent, $sData) . PHP_EOL;
		}
		
		return $sContents;
	}
	
	private function compileJS($sHTML)
	{
		$sContents = '';
		$sLines = explode("\n", $sHTML); 
		foreach($sLines as $iLine => $sData) { 
			if(preg_match("/<!--@importJS\(.*\)-->/imsx", $sData)){
				$openTag = explode("<!--@importJS(", $sData);
				$closeTag = explode(")-->", $openTag[1]);
				$file = FW_USER_FILES . DS . 'js' . DS . $closeTag[0] . '.js';
				if(file_exists($file)){
					$sContent = "<script type=\"text/javascript\">" . PHP_EOL;
					$sContent .= file_get_contents($file). PHP_EOL;
					$sContent .= "</script>";
					$sData = preg_replace("/<!--@importCSS\(" . preg_quote($closeTag[0], "/") . "\)-->/", $sContent, $sData) . PHP_EOL;
				}
			}
			
			$sContent = "<script type=\"text/javascript\" src=\"/resource.php?fetch=jquery&type=library&ext=js\"></script>" . PHP_EOL;
			$sContent .= "<script type=\"text/javascript\" src=\"/resource.php?fetch=sdk&type=library&ext=js&modules=" . implode('|', $this->aModules) . "\"></script>" . PHP_EOL;
			$sContent .= $this->parseModuleExJS();
			$sContent .= $this->parseModuleJS();
			$sContents .= preg_replace("/<!--@moduleJS\(\)-->/", $sContent, $sData) . PHP_EOL;
		}
		
		return $sContents;
	}
}
?>