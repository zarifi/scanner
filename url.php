<?php
namespace Oreilly\ModernPHP\Url;

class Scanner
{
	protected $urls;

	protected $httpClient;


	public function __construct(array $urls)
	{
		$this->urls = $urls;
		$this->httpClient = new \GuzzleHttp\Client();
	}

	public function getInvalidUrls()
	{
		$invalidUrls = [];

		foreach($this->urls as $url){
			try{
				$statusCode = $this->getStatusCodeForUrl($url);

			} catch (\Exception $e){
				$statusCode = 500;
			}
			if ($statusCode >= 400){
				array_push($invalidUrls, [
				'url' => $url,
				'status' => $statusCode
				]);
			}
		}
		return $invalidUrls;
	}

	protected function getStatusCodeForUrl($url)
	{
		$httpResponse = $this->httpClient->options($url);

		return $httpResponse->getStatusCode();
	}
}