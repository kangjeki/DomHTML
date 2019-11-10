<?php
/* this source pulish on github;
 * 
 * @github  https://github.com/kangjeki
 * @author  JC_Programs | Imam Nasrudin <otakpentium404@gmail.com>
**/
namespace DOMParserHTML\Parser;

/* 
 * This is a prser page / Generate HTML file to DOM Selector
**/
Abstract class HTMLParser {
	protected 	$tagCollect 	= [],
				$elCollect 		= [],
				$doc;

	public function __construct($HTML = false) {
		$_rollswitchTag = 0;
		$_rollswitchEl 	= 0;

		if ( $HTML === false ) {
			// parsing document
			$focusPath 		= explode("/", $_SERVER["PHP_SELF"] );
			$focusPath 		= end($focusPath);

			$docHandle 		= fopen( $focusPath, "r" );
			$this->doc 		= fread( $docHandle, filesize($focusPath) );
			fclose($docHandle);
		}
		else {
			$this->doc 		= $HTML;
			$_rollswitchEl 	= 1;
			$_rollswitchTag = 1;
		}

		/* -------------------------------------------------------------------------------
		 * tagging html structrue
		**/
		preg_match_all("|<([^>]+)>|i", $this->doc, $allTagMatch, PREG_SET_ORDER );
		foreach ( $allTagMatch as $tagCt ) {
			// colect html element anda priority html tag first
			if ( preg_match( "|<html(.*)|", $tagCt[0] ) === 1 ) { $_rollswitchTag = 1; }
			else {$_rollswitchEl = 1; $_rollswitchTag = 1;};
			if ( $_rollswitchTag === 1 ) { $this->tagCollect[] = $tagCt[0]; };
			if ( preg_match( "|</html(.*)|", $tagCt[0] ) === 1 ) { $_rollswitchTag = 0; }	
		}

		/* -------------------------------------------------------------------------------
		 * element html structure 
		**/
		$ColectorElements 	= [];
		preg_match_all("|<([^>]+)>(.+?)|U", $this->doc, $allElement, PREG_SET_ORDER );
		foreach ( $allElement as $elCt ) {
			if ( preg_match( "/<html(.*)/", $elCt[0] ) === 1 ) { $_rollswitchEl = 1; }
			if ( $_rollswitchEl === 1 ) { $ColectorElements[] = $elCt[0]; };
			if ( preg_match( "/<\/html(.*)/", $elCt[0] ) === 1 ) { $_rollswitchEl = 0; }	
		}
		
		foreach ( $ColectorElements as $re_allElement ) {
			$reDocument 	= str_replace("<", "|**|<", $re_allElement);			
			$reDocument 	= str_replace(">", ">|**|", $reDocument);			
			$exSlice 	= explode("|**|", $reDocument);
			foreach ($exSlice as $value) {
				$this->elCollect[] = $value;
			}
		}
	}

	abstract function domParser($data);

	// protected function pairedElement() {
	// 	$tagLib 	= ["a", "abbr", "acronym", "address", "applet", "article", "aside", "audio", "b", "basefont", "bdi", "bdo", "big", "blockquote", "body", "button", "canvas", "caption", "center", "cite", "code", "col", "colgroup", "data", "datalist", "dd", "del", "details", "dfn", "dialog", "dir", "div", "dl", "dt", "em", "embed", "fieldset", "figcaption", "figure", "font", "footer", "form", "frame", "frameset", "h6", "head", "header", "hr", "html", "i", "iframe", "ins", "kbd", "label", "legend", "li", "main", "map", "mark", "meta", "meter", "nav", "noframes", "noscript", "object", "ol", "optgroup", "option", "output", "p", "param", "picture", "pre", "progress", "q", "rp", "rt", "ruby", "s", "samp", "script", "section", "select", "small", "source", "span", "strike", "strong", "style", "sub", "summary", "sup", "svg", "table", "tbody", "td", "template", "textarea", "tfoot", "th", "thead", "time", "title", "tr", "tt", "u", "ul", "var", "video"];
	// }

	protected function voidElement($tagStr) {
		// register void element / single tag
		$tag 	= ["area", "base", "br", "col", "command", "embed", "keygen", "param", "source", "track", "wbr", "meta", "input", "img", "br", "hr", "link"];
		$search = array_search($tagStr, $tag);
		if ( $search < 0 || $search === false ) { return false;}
		else { return true; }
	}

	protected function detectTagIs($matchEL) {
		$reTG 	= explode(">", $matchEL);
		$reTG 	= $reTG[0];
		$reTG 	= explode(" ", $reTG);
		$reTG 	= preg_replace("|[^A-Za-z0-9- /]|", "", $reTG[0]);
		return $reTG;
	}

	protected function idOperation($id) {
		$pullCollectID 	= [];
		$finalPullID 	= [];
		$rollElementID 	= 0;
		$openTag 		= "";
		$endTag 		= "";
		$loopStart 		= 0;

		foreach ( $this->elCollect as $elem ) {
			if ( $searchID = preg_match('|id="'. $id .'"|', $elem ) ) {
				$reTG 				= $this->detectTagIs($elem);
				$openTag 			= "<" 	. $reTG;
				$endTag 			= "</" 	. $reTG;
				
				if ( $this->voidElement($reTG) === true ) {
					$pullCollectID[] = $elem;
				}
				else {
					$loopStart 		= 1;
				}
			}
			else if ( $searchID = preg_match("|id='". $id ."'|", $elem ) ) {
				$reTG 				= $this->detectTagIs($elem);
				$openTag 			= "<" 	. $reTG;
				$endTag 			= "</" 	. $reTG;

				if ( $this->voidElement($reTG) === true ) {
					$pullCollectID[] = $elem;
				}
				else {
					$loopStart 		= 1;
				}
			}

			if ($loopStart === 1 ) {
				$rollOpenTag 	= "<" 	. $this->detectTagIs($elem);
				$rollEndTag 	= "<" 	. $this->detectTagIs($elem);

				if ( $rollOpenTag === $openTag ) {
					$rollElementID 	+= 1;
				}
			
				if ( $rollElementID >= 1 ) {
					/* -----------------------------------------
					 * Pull Colect Element Matchs is not void
					**/
					$pullCollectID[] = $elem;
				}

				if ( $rollEndTag === $endTag ) { 
					$rollElementID 	-= 1;
					if ( $rollElementID === 0 ) {
						$loopStart 		= 0;
					} 
				}				
			}
		}

		$finalPullID[] = implode("", $pullCollectID);
		/*
		 * Final Retrun element id
		**/
		return $finalPullID[0];

	}

	protected function classOperation($class, $collect = false) {
		$pullCollectCLASS 	= [];
		$finalPullCLASS 	= [];
		$rollElementCLASS 	= 0;
		$openTag 			= "";
		$endTag 			= "";
		$loopStart 			= 0;
		$rollIndex 			= 0;

		foreach ( $this->elCollect as $elem ) {
			if ( preg_match('|class="(.*)'. $class .'(.*)|', $elem ) ) {
				$reTG 				= $this->detectTagIs($elem);
				$openTag 			= "<" 	. $reTG;
				$endTag 			= "</" 	. $reTG;
				
				if ( $this->voidElement($reTG) === true ) {
					$pullCollectCLASS[$rollIndex][] = $elem;
					$rollIndex 						+= 1;
				}
				else {
					$loopStart 			= 1;
				}
			}
			else if ( preg_match("|class=(.*)'". $class ."(.*)|", $elem ) ) {
				$reTG 				= $this->detectTagIs($elem);
				$openTag 			= "<" 	. $reTG;
				$endTag 			= "</" 	. $reTG;
				if ( $this->voidElement($reTG) === true ) {
					$pullCollectCLASS[$rollIndex][] = $elem;
				}
				else {
					$loopStart 			= 1;
				}
			}

			if ($loopStart === 1 ) {
				$rollOpenTag 	= "<" 	. $this->detectTagIs($elem);
				$rollEndTag 	= "<" 	. $this->detectTagIs($elem);

				if ( $rollOpenTag === $openTag ) {
					$rollElementCLASS 	+= 1;
				}
			
				if ( $rollElementCLASS >= 1 ) {
					/*
					 * Pull Colect Element Matchs
					**/
					$pullCollectCLASS[$rollIndex][] = $elem;
				}

				if ( $rollEndTag === $endTag ) { 
					$rollElementCLASS 	-= 1;
					$rollIndex 			+= 1;
					if ( $rollElementCLASS === 0 ) {
						$loopStart 		= 0;
					} 
				}				
			}
		}
		foreach ( $pullCollectCLASS as $pull ) {
			$finalPullCLASS[] = implode("", $pull);
		}
		
		/*
		 * Final Retrun element id
		**/
		if ( $collect == false ) {
			$finalPullCLASS = $finalPullCLASS[0];
		}
		return $finalPullCLASS;
	}

	protected function tagOperation($tag, $collect = false) {
		$finalSelctor 			= [];
		$strElemIdentifyTag 	= "";
		$rotateTag 				= 0;
		$nodeLength 			= 0;
		$openTag 				= "<" 	. $tag;
		$endTag 				= "</" 	. $tag;
		$openLength 			= strlen($openTag);
		$endLength 				= strlen($endTag);

		/* -------------------------------------------------------------------------------------
		 * create Identify first Match tag index 0;
		**/
		foreach ( $this->tagCollect as $key => $tgs ) { 
			$reTG 	= $this->detectTagIs($tgs);
			if ( $strElemIdentifyTag === "" ) {
				if ( substr($tgs, 0, $openLength) === $openTag ) {
					if ( $reTG === $tag ) {
						$strElemIdentifyTag = $tgs;
					}
				}
			}
		}

		/* -------------------------------------------------------------------------------------
		 * exec and filter type of tag
		**/
		if ( $this->voidElement($tag) == true ) {
			if ( $collect === true ) {
				foreach ( $this->tagCollect as $tgsMC ) {
					if ( "<" . $this->detectTagIs($tagMC) === $openTag ) { 
						$finalSelctor[] = $tgsMC;
					}
				}	
			}
			else {
				$finalSelctor = $strElemIdentifyTag;
			}
		}
		else {
			/* -------------------------------------------------------------------------------------
			 * log elemCollection
			**/
			foreach ( $this->elCollect as $elem ) {
				if ( $this->detectTagIs($elem) !== "" ) {
					if ( "<" . $this->detectTagIs($elem) == $openTag ) {
						$nodeLength += 1;
					}	
				}
			}

			$execPull 	= [];
			$rollPlus 	= 0;
			$rollNode 	= 0;
			foreach ( $this->elCollect as $elem ) {
				/* identify open tag*/
				$reTG 	= $this->detectTagIs($elem);
				if ( $this->detectTagIs($elem) !== "" ) {
					if ( "<" . $this->detectTagIs($elem) == $openTag ) {
						$rollPlus 	+= 1;
						$rotateTag 	+= 1;
					}

					if ( $rotateTag >= 1 ) {
						// put final element selector =================================================
						// if first section succesfuly
						for ($n = $rollNode; $n < $rollPlus; $n++) {
							$execPull[$n][] = $elem;
						}
						// ============================================================================
					}

					if ( "<" . $this->detectTagIs($elem) == $endTag ) {
						$rotateTag 	-= 1;
						if ($rotateTag === 0) {
							$rollNode = $rollPlus;
						}
					}
				}
			}	

			/*
			 * flex all group tag to finish selector
			**/
			foreach($execPull as $elFIN) {
				$finalSelctor[] = implode("", $elFIN);
			}
			// tihs non plural
			if ($collect === false) {
				$nonCollect 	= array_shift( $finalSelctor );
				$finalSelctor 	= $nonCollect;
			}			
		}

		// return parser selector
		return $finalSelctor;
	}

	/* --------------------------------------------------------------------------------------------------------------
	 * Metode Selector Tag Index 0
	**/
	public function querySelector($selector = false) {
		if ( $selector !== false ) {
			$tagIdentify 	= "";

			if ( $selector[0] !== "#" && $selector[0] !== "." ) { 
				$tagIdentify = "tag"; 
				return $this->tagOperation($selector); 
			}
			else if ($selector[0] === "." ) { 
				$tagIdentify = "class"; 
				return $this->classOperation( str_replace(".", "", $selector) ); 
			}
			else if ( $selector[0] === "#" ) {
				$tagIdentify = "id"; 
				return $this->idOperation( str_replace("#", "", $selector) ); 
			}
		}
		else {
			echo "ERROR! Parameter querySelector is False!";
		}
	}

	/* --------------------------------------------------------------------------------------------------------------
	 * Metode Selector All
	**/
	public function querySelectorAll($selector = false) {
		if ( $selector !== false ) {
			$tagIdentify 	= "";

			if ( $selector[0] !== "#" && $selector[0] !== "." ) { 
				$tagIdentify = "tag"; 
				return $this->tagOperation($selector, true); 
			}
			else if ($selector[0] === "." ) { 
				$tagIdentify = "class"; 
				return $this->classOperation( str_replace(".", "", $selector), true ); 
			}
			else if ( $selector[0] === "#" ) {
				$tagIdentify = "id"; 
				return $this->idOperation( str_replace("#", "", $selector), true ); 
			}
		}
		else {
			echo "ERROR! Parameter querySelector is False!";
		}
	}

	/* --------------------------------------------------------------------------------------------------------------
	 * Metode get Elements By Tag
	**/
	public function getElementsByTagName($tagName = false) {
		if ($tagName !== false) {
			return $this->tagOperation($tagName, true);
		}
		else {
			echo "ERROR! Parameter Tag Name is False!";
		}
	}

	/* --------------------------------------------------------------------------------------------------------------
	 * Metode get Elements By Class
	**/
	public function getElementsByClassName($className = false) {
		if ($className !== false) {
			return $this->classOperation( str_replace(".", "", $className), true ); 
		}
		else {
			echo "ERROR! Parameter Class Name is False!";
		}
	}

	/* --------------------------------------------------------------------------------------------------------------
	 * Metode get Elements By Id
	**/
	public function getElementById($idName = false) {
		if ($idName !== false) {
			return $this->idOperation( str_replace(".", "", $idName) ); 
		}
		else {
			echo "ERROR! Parameter Id is False!";
		}
	}

}