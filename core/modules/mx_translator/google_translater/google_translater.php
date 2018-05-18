<?php
/**
 * @package phpBB Extension - phpBB MX-Translator
 * @copyright (c) 2018 orynider
 * orynider\mx_translator\google_translater 
 *
 *
 * Based on  GoogleTranslate.class.php by Adrián Barrio Andrés
 * link https://statickidz.com/
 * and Paris N. Baltazar Salguero <sieg.sb@gmail.com>
 *
 * Based on GoogleTranslater Class by Andrew Kulakov <avk@8xx8.ru>
 * GoogleTranslater is a PHP interface for http://translate.google.com/
 * It sends a request to the google translate service, gets a response and 
 * provides the translated text.
 * @license https://github.com/Andrew8xx8/GoogleTranslater/blob/master/MIT-LICENSE.txt
 * @copyright Andrew Kulakov (c) 2011
 *
 */
//namespace orynider\mx_translator\google_translater;
if (!defined('IN_PHPBB'))
{
	exit;
}
class google_translater 
{
	/**
	* @var string Some errors
	*/
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\language\language */
	var $lang = array();
	/** @var  */	
	private $errors = '';
	/** @var  */	
	private $http_referer = '';	
	/** @var  */	
	private $uri = '';
	
	/**
	* Constructor
	*/
	public function __construct_(\phpbb\language\language $lang, \phpbb\request\request $request)
	{
		if (!function_exists('curl_init'))
		{
			$this->errors = 'No cURL support';
		}
		$this->lang = $lang;
		$this->http_referer = $request->variable('HTTP_REFERER', '', false,\phpbb\request\request_interface::SERVER);		
		$this->uri = 'http://translate.google.com/translate_a/t';
		
	}   
	/**
	* Constructor
	*/
	public function google_translater()
	{
		if (!function_exists('curl_init'))
		{
			$this->errors = 'No cURL support';
		}
		$this->lang = $lang;
		$this->http_referer = $_SERVER['HTTP_REFERER'];		
		$this->uri = 'http://translate.google.com/translate_a/t';		
	}     
	/**
	* Translate text.
	* @param  string $text          Source text to translate
	* @param  string $language_from  Source language
	* @param  string $language_to    Destenation language 
	* @param  bool   $translit      If true function return transliteration of source text 
	* @return string|bool           Translated text or false if exists errors
	*/
	public function translate($text, $language_from = 'en', $language_to = 'ro', $translit = false)
	{	
		if (is_array($text))
		{
			//$text = str_replace('=', ':', http_build_query($text, null, ','));
			$data = '';
			$result = '';
			//$counter = count($text);
			foreach ($text as $key => $value)
			{
				if (is_array($value))
				{
					//$value = utf8_wordwrap(serialize($value), 75, "\n", true);
					$value = implode('[<#>]', $value);
				}
				//$text[$key] = $value;			
				$counter++;									
				for($i = 0; $i < strlen($value); $i += 250)
				{
					$sub_text = substr($value, $i, 250);				
					if (empty($this->errors) && !empty($value))
					{
						$client = 'at'; /** client t or at **/
						$qs = http_build_query(array(
							'client' => $client,
							'text' => urlencode($sub_text),
							'hl' => $language_to,
							'sl' => $language_from,
							'tl' => $language_to,
							'otf' => 1,
							'multires' => 1,
							'ssel' => 0,
							'tsel' => 0,
							'uptl' => $language_to,
							'sc' => 1,
							'ie' => 'UTF-8'
						));
						/** Google translate URL **/
						$subsc_url = "https://translate.google.com/translate_a/single?client=$client&text=".urlencode($sub_text)."&hl=$language_to&sl=$language_from&tl=$language_to&otf=2&multires=1&ssel=0&tsel=0&sc=1&iid=1dd3b944-fa62-4b55-b330-74909a99969e";
						$sub01_url = "$this->uri?client=$client&text=".urlencode($sub_text)."&hl=$language_to&sl=$language_from&tl=$language_to&otf=2&multires=1&ssel=0&tsel=0&sc=1";
						$sub02_url = "$this->uri?client=$client&text=".urlencode($sub_text)."&hl=$language_to&sl=$language_from&tl=$language_to&otf=1&multires=1&ssel=0&tsel=0&uptl=$language_to&sc=1";
						$response = $this->_curl_to_google($sub02_url);
						$domain_validation = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
						if(preg_match("$domain_validation", $response))
						{
							$response = $this->_curl_to_google($this->uri.'?'.$qs);
							//return $response;
						}
						//print_r($response);
						$data = $this->_parce_google_response($response, $translit, $language_from, $language_to);
					}
					else
					{
						return false;
					}					
				}
				$text[$key] = $data;
			}
			$result = $text;			
		}
		else		
		{
			//$text = str_replace('=', ':', http_build_query($text, null, ','));		
			for($i = 0; $i < strlen($text); $i += 250)
			{
				$sub_text = substr($text, $i, 250);				
				if (empty($this->errors))
				{
					$result = '';
					$client = 'at'; /** client t or at **/
					$qs = http_build_query(array(
						'client' => $client,
						'text' => urlencode($sub_text),
						'hl' => $language_to,
						'sl' => $language_from,
						'tl' => $language_to,
						'otf' => 1,
						'multires' => 1,
						'ssel' => 0,
						'tsel' => 0,
						'uptl' => $language_to,
						'sc' => 1,
						'ie' => 'UTF-8'
					));
					/** Google translate URL **/
					$subsc_url = "https://translate.google.com/translate_a/single?client=$client&text=".urlencode($sub_text)."&hl=$language_to&sl=$language_from&tl=$language_to&otf=2&multires=1&ssel=0&tsel=0&sc=1&iid=1dd3b944-fa62-4b55-b330-74909a99969e";
					$sub01_url = "$this->uri?client=$client&text=".urlencode($sub_text)."&hl=$language_to&sl=$language_from&tl=$language_to&otf=2&multires=1&ssel=0&tsel=0&sc=1";
					$sub02_url = "$this->uri?client=$client&text=".urlencode($sub_text)."&hl=$language_to&sl=$language_from&tl=$language_to&otf=1&multires=1&ssel=0&tsel=0&uptl=$language_to&sc=1";
					$response = $this->_curl_to_google($sub02_url);
					$domain_validation = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
					if(preg_match("$domain_validation", $response))
					{
						$response = $this->_curl_to_google($this->uri.'?'.$qs);
						//return $response;
					}				
					$result .= $this->_parce_google_response($response, $translit, $language_from, $language_to);
				}
				else
				{
					return false;
				}			
			}				
		}
		return $result;		
	}
	
	/**
	* Translate array.
	* @param  array  $array         Array with source text to translate
	* @param  string $language_from  Source language
	* @param  string $language_to    Destenation language
	* @param  bool   $translit      If true function return transliteration of source text 
	* @return array|bool            Array  with translated text or false if exists errors
	*/
    public function translate_array($array, $language_from = 'en', $language_to = 'ro', $translit = false) 
    {
        if (empty($this->errors)) 
		{
			$text = implode('[<#>]', $array);
			$response = $this->translate($text, $language_from, $language_to, $translit);
            return $this->_explode($response);
        } 
		else
		{		
            return false;
        }		
	}

    public function get_languages()
    {
        if (empty($this->errors)) 
		{
            $page = $this->_curl_to_google('http://translate.google.com/');
            preg_match('%<select[^<]*?tl[^<]*?>(.*?)</select>%is', $page, $match);
            preg_match_all("%<option.*?value=\"(.*?)\">(.*?)</option>%is", $match[0], $languages);
            $result = array();
            for($i = 0; $i < count($languages[0]); $i++)
			{
				$result[$languages[1][$i]] = $languages[2][$i];
            }
            return $result;
		} 
		else
		{
			return false;
		}			
	}
    
    public function get_languages_html()
    {
        if (empty($this->errors)) 
		{
            $page = $this->_curl_to_google('http://translate.google.com/');
            preg_match('%<select[^<]*?tl[^<]*?>(.*?)</select>%is', $page, $match);
            return $match[1];
		} 
		else
		{
			return false;
		}
    }
	
	public function get_errors()
	{
		return $this->errors;
	}
	
	private function _explode($text)
	{
		/*
		$text = str_replace('% ', '%', $text);	
		$text = str_replace('&', '&amp;', $text);
		$text = str_replace('>', '&gt;', $text);
		$text = str_replace('<', '&lt;', $text);

		$text = str_replace("\n", '&#10;', $text);
		$text = str_replace("\r", '&#13;', $text);
		$text = str_replace("\t", '&#9;', $text);
		
		$text = urldecode($text);
		*/
		$text = preg_replace('%\[\s*<\s*#\s*>\s*\]%', '[<#>]', $text);
		return array_map('trim', explode('[<#>]', $text));
	}
 
    private function _curl_to_google($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		/* ** /
		if (isset($_SERVER['HTTP_REFERER'])) 
		{
 			curl_setopt($ch, CURLOPT_REFERER, trim($this->http_referer));	
		}
		/** **/
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');		
		//curl_setopt($ch, CURLOPT_USERAGENT, @get_browser(null, true));
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win32; x86; rv:52.7) Gecko/20100101 Firefox/52.7.2');  
		$response = curl_exec($ch);
        // Check if any error occured
        if(curl_errno($ch))
        {
            $this->errors .=  'Curl Error: ' . curl_error($ch);
            return false;
        }
        curl_close($ch);
        return $response;
    }
	
	private function _parce_google_response($response, $translit = false, $language_from = 'en', $language_to = 'ro')
	{	
		if (empty($this->errors))
		{
            $result = '';
			$json = json_decode($response);
			//Force array
			$sentences = $json->sentences;
			$sentences = is_array($sentences) ? $sentences : array($sentences);
			foreach ($sentences as $sentence) 
			{
                $result .= $translit ? $sentence->translit : $sentence->trans;  
            }
            return $result;
		} 
		else
		{
			return false;
		}
    }
}
?>