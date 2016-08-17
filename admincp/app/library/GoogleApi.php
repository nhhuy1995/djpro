<?php
namespace DjCms\Library;
class GoogleApi {
    private $emailAddress = '266383643619-02ac9l8hcsnjcfb0f0c5nliibmghn82h@developer.gserviceaccount.com';
    private $scopes = array('https://www.googleapis.com/auth/youtube');
    private $privateKeyPassword = 'notasecret';


    function __construct() {
        require_once dirname(__FILE__).'/Google/autoload.php';
    }

    public function createConnection() {
        $private_key = file_get_contents(dirname(__FILE__).'/API Project-016c00c84fae.p12');
        $credentials = new \Google_Auth_AssertionCredentials(
            $this->emailAddress,
            $this->scopes,
            $private_key,
            $this->privateKeyPassword
        );

        $client = new \Google_Client();
        $client->setAssertionCredentials($credentials);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion();
        };
        $json = json_decode($client->getAccessToken());

    }

}