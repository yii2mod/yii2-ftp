<?php

namespace yii2mod\ftp\components;

use yii\base\Component;
use yii2mod\ftp\FtpClient as Ftp;

/**
 * Class Ftp
 * @package frontend\components
 */
class FtpClient extends Component
{
    /**
     * @var
     */
    public $host;

    /**
     * @var
     */
    public $user;

    /**
     * @var
     */
    public $password;

    /**
     * @var int
     */
    public $port = 21;

    /**
     * @var bool
     */
    public $ssl = false;

    /**
     * @var bool
     */
    public $passive = false;

    /**
     * @var int
     */
    public $timeout = 90;

    public function init()
    {
        parent::init();
    }

    /**
     * @return Ftp
     * @throws \yii2mod\ftp\FtpException
     */
    public function connect()
    {
        $ftp = new Ftp();
        $ftp->connect($this->host, $this->ssl, $this->port, $this->timeout);
        $ftp->login($this->user, $this->password);
        $ftp->pasv($this->passive);

        return $ftp;
    }
}