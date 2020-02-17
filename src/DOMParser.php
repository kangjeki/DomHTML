<?php

/**
 * this source pulish on github;
 * 
 * @github  https://github.com/kangjeki
 * @author  kangjeki | Imam Nasrudin <otakpentium404@gmail.com>
**/
namespace DOMParserHTML;

/** 
 * Public DOM method
**/

class DOMParser extends HTMLParser {

	public function domParser($data) {
		return $data;
	}
	
	protected function dataAttributes($htmlData, $atrName) {
		preg_match_all("|<([^>]+)>|i", $htmlData, $elData, PREG_SET_ORDER );

		if ( count($elData) !== 0 ) {
			$finalList 	= [];
			$strElem 	= $elData[0][0];
			$attrMatch 	= "";

			if ( preg_match("|".$atrName."='(.+?)'|i", $strElem, $elData) >= 1 ) {
				$attrMatch = $elData;
			}
			else if ( preg_match('|'.$atrName.'="(.+?)"|i', $strElem, $elData) >= 1 ) {
				$attrMatch = $elData;
			}
			else {
				echo "Attribute ". $atrName ." Not Found!";
			}
			
			if ($attrMatch !== "") {
				$strAttr 	= $elData[1];
				$strAttr 	= explode(" ", $strAttr);
				foreach ( $strAttr as $atrData ) {
					$atrCheck = preg_replace("|[^A-Za-z0-9-_]|", "", $atrData);
					if ( strlen($atrCheck) !== 0 ) {
						$finalList[] = $atrCheck;
					}
				}
				if ( count($finalList) == 1 ) {
					return $finalList[0];
				}
				else {
					return $finalList;
				}
			}
		}
		else {
			echo "Error! Parsing Html Element!";
		}
	}

	// get manual data attribute
	public function getAttribute($elem = false, $atr = false) {
		if ($elem == false) {
			echo "Failed! Parameter Element";
			exit();
		}
		if ($atr == false) {
			echo "Failed! Parameter Attribute";
			exit();
		}
		if ( $elem !== false && $atr !== false ) {
			return $this->dataAttributes($elem, $atr);
		}
	}

	// get value attribute id
	public function id($elem = false) {
		if ($elem !== false) {
			return $this->dataAttributes($elem, "id");
		}
		else {
			echo "Failed! Parameter Id";
		}
	}

	// get value attribute value
	public function value($elem = false) {
		if ($elem !== false) {
			return $this->dataAttributes($elem, "value");
		}
		else {
			echo "Failed! Parameter Value";
		}
	}

	// get value classList
	public function classList($elem = false) {
		if ($elem !== false) {
			return $this->dataAttributes($elem, "class");
		}
		else {
			echo "Failed! Parameter classList";
		}
	}

	// get exist class
	public function existClass($elem = false, $className = false) {
		if ( $elem !== false && $className !== false ) {
			$classMatch = false;
			$classList 	= $this->dataAttributes($elem, "class");

			if ( is_array($classList) == true ) {
				$search = array_search($className, $classList);
				if ( $search < 0 || $search === false ) {
					$classMatch = false;
				}
				else {
					$classMatch = true;
				}
			}
			else {
				if ( $classList == $className ) {
					$classMatch = true;
				}
				else {
					$classMatch = false;
				}
			}
			return $classMatch;
		}
		else {
			echo "Failed! Parameter Is False";
		}
	}
}