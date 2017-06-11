<?php 
/**
 * Kilesh - PHP library for declension of cases in tatar language.
 *
 * @author F.Kayumova <79872633268l@gmail.com>
 * @version 1.0
 */

namespace kilesh;

/**
 * Main Class.
 */
class kilesh
{ 
    /**
     * Input word.
     */
	public $inputText; 
	/**
     * Array of solid vowels letters.
     */
	public $arr = array('а', 'о', 'у', 'е', 'ы');
	/**
     * Array of consonants voiced letters.
     */
	public $sog = array('б', 'й','г','з','в','р','л', 'ъ');
	/**
     * Array of nasal letters.
     */
	public $nos = array('м', 'н', 'ң');
	/**
     * Array of vowels letters.
     */
	public $glas = array('а','у','е','ы','о','я','и', 'ә', 'ү', 'ө' );
	/**
     * Array of blank consonants letters.
     */
	public $glux = array('к', 'ш','ф','п','т');
	/**
     * Array of endings.
     */
	public $valid = array('1'=>'ка', '2'=>'га', '3' =>'гә', '4'=>'кә','5' =>'ның', '6'=>'нең', '7'=>'ны','8'=>'не','9'=>'дан', '10'=>'дән', '11'=>'тән',  '12'=>'нан', '13'=>'нән','14'=> 'да', '15'=>'дә', '18'=>'та ', '16'=>'тә','17'=>'тан',);

	/**
     * This method return a case name.
     * 
     * @param string $inputText Input word.
     * @return string Name of case.
     */
	public function padezh($inputText)
	{
		$valide = $this->valid;
		
	    foreach ($valide as $val) {
	        $va = mb_stripos($inputText, $val);
	        if (false!=$va) {
	            $oc_pad = mb_substr($inputText, $va);
	            $oc_key = array_search($oc_pad, $valide);

	            switch ($oc_key) {
	            	case '1':
	            	case '2':
	            	case '3':
	            	case '4':
	            		$result = "Юнәлеш килешендә";	
	            		break;

	            	case '5':
	            	case '6':
	            		$result = "Иәлек килешендә";	
	            		break;

	            	case '7':
	            	case '8':
	            		$result = "Төшем килешендә";	
	            		break;
	            	
	            	case '9':
	            	case '10':
	            	case '11':
	            	case '12':
	            	case '13':
	            	case '17':
	            		$result = "Чыгыш килешендә";	
	            		break;

	            	case '14':
	            	case '15':
	            	case '16':
	            	case '18':
	            		$result = "Юнәлеш килешендә";	
	            		break;

	            	default:
	            		$result = "Баш килешендә";
	            		break;
	            }
	            break;
       		}
         	elseif ($va==false) {
                $result = "Баш килешендә"; 
            }
        
    	}

    	return $result;
	}

	/**
     * This method clear word from case.
     * 
     * @param string $inputText Input word.
     * @return string Filtered word.
     */
	public function valide($inputText)
	{
	    $valide = $this->valid;
	    
	    foreach ($valide as $val) {
	        $va = mb_stripos($inputText, $val);
	        if (false!=$va) {
	            $oc_pad = mb_substr($inputText, $va);
	            $oc_key = array_search($oc_pad, $valide);
	            $count = mb_strlen($oc_pad);
	            if($count==2) {
	                $result = mb_substr($inputText,  0, -2); 
	                break;
	            }
	            else {
	                $result = mb_substr($inputText,  0, -3); 
	            }
	             break;
	        }
	        elseif ($va==false) {
	            $result = $inputText; 
	        }
	    }

    	return $result;
	}

	/**
     * This method determines the end of the word and inserts the correct ending.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function ocon($inputText) 
	{ 
		$arr1 = preg_split('#(?<!^)(?!$)#u', $inputText);
		$count = count($arr1)-1;

		for($j = 0; $j<=count($arr1); $j++) {
				if(in_array($arr1[$j], $this->arr)) {
					$re = "а";
					break;
				}
				else {
					$re = "ә";
				}
		} 

		if($arr1[$count]=="ь") {
			$re = "ә";
		}
		elseif($arr1[$count]=="ъ") {
			$re = "а";
		}
		return $re;
	} 

	/**
     * This method return a word in nominative case.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function bk($inputText) 
	{ 
		$result =  $this->valide($inputText);

		return $result;
	}

	/**
     * This method return a word in genetive case.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function ik($inputText) 
	{ 
		$inputText =  $this->valide($inputText);
		$arr1 = preg_split('#(?<!^)(?!$)#u', $inputText);
		$count = count($arr1)-1;

		for($i = 0; $i<=count($arr1); $i++) {
			
			if(in_array($arr1[$i], $this->arr)) {
				$result = $inputText."ның";
				break;
			}
			else {
				$result = $inputText."нең";
			}
		} 

		if($arr1[$count]=="ь") {
			$result = $inputText."нең";
		}
		elseif($arr1[$count]=="ъ") {
			$re= "ның";
		}

		return $result;
	}

	/**
     * This method return a word in dative case.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function yik($inputText) 
	{ 
		$inputText =  $this->valide($inputText);
		$arr1 = preg_split('#(?<!^)(?!$)#u', $inputText);
		$count = count($arr1)-1;

		if(in_array($arr1[$count], $this->glux)) {
			$result = $inputText."к".$this->ocon($inputText);
		}
		else {
			for($i = 0; $i<=count($arr1); $i++) {	
				if(in_array($arr1[$i], $this->sog)||(in_array($arr1[$count], $this->nos))) {
					$result = $inputText."г".$this->ocon($inputText);
					break;
				}
				else {
					$result = $inputText."к".$this->ocon($inputText);
				}
			}
		}

		return $result;
	}

	/**
     * This method return a word in accusative case.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function tk($inputText) 
	{ 
		$inputText =  $this->valide($inputText);
		$arr1 = preg_split('#(?<!^)(?!$)#u', $inputText);
		$count = count($arr1)-1;

		for($i = 0; $i<=count($arr1); $i++) {
			if(in_array($arr1[$i], $this->arr)) {
				$result = $inputText."ны";
				break;
			}
			else {
				$result = $inputText."не";
			}
		} 

		if($arr1[$count]=="ь") {
			$result = $inputText."не";
		}
		elseif($arr1[$count]=="ъ") {
			$result = "ны";
		}

		return $result;
	}

	/**
     * This method return a word in instrumental case.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function chk($inputText) 
	{
		$inputText =  $this->valide($inputText);
		$arr1 = preg_split('#(?<!^)(?!$)#u', $inputText);
		$count = count($arr1)-1;

		if((in_array($arr1[$count], $this->glas))||(in_array($arr1[$count], $this->sog))) {
			$result = $inputText."д".$this->ocon($inputText)."н";
		}
		elseif(in_array($arr1[$count], $this->nos)) {
			$result = $inputText."н".$this->ocon($inputText)."н";
		}
		elseif($arr1[$count]=="ь") {
			$result = $inputText."д".$this->ocon($inputText)."н";	
		}
		else {
			$result = $inputText."т".$this->ocon($inputText)."н";
		}
		
		return $result;
	}

	/**
     * This method return a word in prepositional case.
     * 
     * @param string $inputText Input word.
     * @return string Output word.
     */
	public function yvk($inputText) 
	{
		$inputText =  $this->valide($inputText);
		$arr1 = preg_split('#(?<!^)(?!$)#u', $inputText);
		$count = count($arr1)-1;

		if((in_array($arr1[$count], $this->glas))||(in_array($arr1[$count], $this->sog))||(in_array($arr1[$count], $this->nos))) {
			$result = $inputText."д".$this->ocon($inputText);
		}
		elseif($arr1[$count]=="ь") {
			$result = $inputText."д".$this->ocon($inputText);		
		}
		else {
			$result = $inputText."т".$this->ocon($inputText);
		}
		
		return $result;
	}
} 
