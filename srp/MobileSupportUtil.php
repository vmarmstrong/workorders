<?php /*last update: 11/2010 */ ?>

<?php
class MobileSupportUtil
{
	function getUserAgent()
	{
		$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		return $userAgent;
	}
	function getAcceptHeader()
	{
		$acceptHeader = strtolower($_SERVER['HTTP_ACCEPT']);
		return $acceptHeader;
	}
	function getWapProfile()
	{
		$wapProfile = strtolower($_SERVER['HTTP_X_WAP_PROFILE']);
		return $wapProfile;
	}
	function getHttpProfile()
	{
		$httpProfile = strtolower($_SERVER['HTTP_PROFILE']);
		return $httpProfile;
	}
	function isMobileDevice()
	{
		$userAgent = $this->getUserAgent();
		$acceptHeader = $this->getAcceptHeader();
		$wapProfile = $this->getWapProfile();
		$httpProfile = $this->getHttpProfile();
		$checkResult = false;
		$mobileDeviceList = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda','xda-');
		switch(true)
		{
			case (strpos($userAgent, 'ipod') !== false);
				$checkResult = 'iPod';
				break;
			case (strpos($userAgent, 'iphone') !== false);
				$checkResult = 'iPhone';
				break;
			case (strpos($userAgent, 'android') !== false);
				$checkResult = 'Android';
				break;
			case (strpos($userAgent, 'blackberry') !== false);
				$checkResult = 'Blackberry';
				break;
			//case (strpos($userAgent, 'Windows Phone') !== false || strpos($userAgent, 'IEMobile') !== false || strpos($userAgent, 'Windows Mobile') !== false);
			//	$checkResult = 'Windows';
			//	break;
			case (strpos($userAgent, 'webos') !== false);
				$checkResult = 'WebOS';
				break;
			case (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', $userAgent));
				$checkResult = "Generic";
				break;
			case (in_array(substr($userAgent, 0, 4), $mobileDeviceList));
				$checkResult = "Generic";
				break;
			case (strpos($acceptHeader, 'wap') !== false || strpos($acceptHeader, 'wml') !== false);
				$checkResult = "Unknown";
				break;
			case ($wapProfile != null || $httpProfile != null);
				$checkResult = "Unknown";
				break;	
		}	
		return $checkResult;
	}		
}
?>