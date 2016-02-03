<?php

namespace Bacon\Bundle\RDStationBundle\Service;

/**
 * Classe responsavel pela integração com a API do RD Station
 *
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 * @version 0.1
 */
class Api
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $privateToken;

    /**
     * @var string
     */
    private $baseURL;

    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @param string $privateToken
     * @param string $token
     *
     * @throws \Exception
     */
    public function __construct($privateToken,$token,$baseUrl,$version)
    {
        if ( empty($privateToken)  )
            throw new \Exception("Inform RDStationAPI.privateToken as the first argument.");

        if ( empty($token)  )
            throw new \Exception("Inform RDStationAPI.token");

        $this->token = $token;
        $this->privateToken = $privateToken;
        $this->baseURL = $baseUrl;
        $this->apiVersion = $version;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function getURL( $type = 'generic' )
    {
        switch($type) {
            case 'generic':
                return $this->baseURL . '/' . $this->apiVersion . '/services/' . $this->privateToken .'/generic';
            case 'leads':
                return $this->baseURL . '/' .$this->apiVersion . '/leads/';
            case 'conversions':
                return $this->baseURL . '/' .$this->apiVersion . '/conversions';
        }
    }

    /**
     * @throws \Exception
     */
    protected function validateToken()
    {
        if(empty($this->token))
            throw new \Exception("Inform RDStation.token as the second argument when instantiating a new RDStationAPI object.");
    }


    /**
     * @param string $method
     * @param $url
     * @param array $data
     *
     * @return bool
     */
    protected function request( $method = 'POST', $url, $data=array())
    {
        $data['token_rdstation'] = $this->token;

        $JSONData = json_encode($data);

        $URLParts = parse_url($url);

        $fp = fsockopen(
            $URLParts['host'],
            isset( $URLParts['port'] ) ? $URLParts['port']:80,
            $errno,
            $errstr,
            30
        );

        $out  = $method." ".$URLParts['path']." HTTP/1.1\r\n";
        $out .= "Host: ".$URLParts['host']."\r\n";
        $out .= "Content-Type: application/json\r\n";
        $out .= "Content-Length: ".strlen($JSONData)."\r\n";
        $out .= "Connection: Close\r\n\r\n";
        $out .= $JSONData;

        $written = fwrite($fp, $out);
        fclose($fp);

        return ( $written === false ) ? false : true;
    }

    public function api($type,$method,$data)
    {
        $typeOptions = [
            'generic',
            'leads',
            'conversions'
        ];

        if (!in_array($type,$typeOptions))
            throw new \Exception('Endpoint not exists');

        $this->validateToken();

        if ( empty($data['identificador']) )
            $data['identificador'] = 'app-integration';

        return $this->request($method,$this->getURL($type),$data);
    }
}
