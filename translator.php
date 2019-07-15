<?php
require 'vendor/autoload.php';
use Stichoza\GoogleTranslate\GoogleTranslate;

if($_POST['password'] != 'tester') {
	exit('Zlé heslo!');
}

$k = array(
	
);

$from = 'sk';
$to = 'en';
$translatedText = '';
$code = 0;

/*
* NASTAVENIE MODU
*/

$mode = 'auto'; //v pripade testovania jednej ip zmenim na manual


$html = '<ol>';

if($mode === 'auto') {
	foreach($k as $ip) {
		sleep(1);
		
		try {
			$tr = new GoogleTranslate($to, $from, [
				'timeout' => 2,
				'cookie' => true,
				'proxy' => $ip,
				//'debug' => true,
				'headers' => [
					'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
				],	
			]);
			$translatedText = $tr->translate('ahoj');
			$html .= '<li>';
			$html .= '<strong>'.$ip.'</strong><br>';
			$html .= ' - ';
			$html .= $translatedText;
			$html .= '</li>';
		} 
		
		//Odchyti ErrorException aby nezapisalo do logu
		catch (ErrorException $e) {
			$code = $e->getMessage();
			$html .= '<li>';
			$html .= '<strong style="color:red">'.$ip.'</strong><br>';
			$html .= ' - ';
			$html .= strip_tags($code);
			$html .= '</li>';
		}		
	}
}
else {
	$ip = $k[array_rand($k, 1)];

	try {
		$tr = new GoogleTranslate($to, $from, [
			'timeout' => 5,
			'cookie' => true,
			'proxy' => $ip,
			//'debug' => true,
			'headers' => [
				'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
			],	
		]);
		$translatedText = $tr->translate('ahoj');
		$html .= '<li>';
		$html .= '<strong>'.$ip.'</strong><br>';
		$html .= ' - ';
		$html .= $translatedText;
		$html .= '</li>';
	} 

	//Odchyti ErrorException aby nezapisalo do logu
	catch (ErrorException $e) {
		$code = $e->getMessage();
		$html .= '<li>';
		$html .= '<strong style="color:red">'.$ip.'</strong><br>';
		$html .= ' - ';
		$html .= strip_tags($code);
		$html .= '</li>';
	}
}

$html .= '</ol>';
echo $html;


