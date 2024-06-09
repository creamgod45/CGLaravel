<?php

namespace App\Lib\Utils;

use App\Lib\I18N\I18N;
use Illuminate\Http\Request;

class CGLaravelControllerInit
{
    /**
     * @var I18N $i18N 國際化語言系統
     */
    private I18N $i18N;
    /**
     * @var array $URLParams URL 參數解析
     */
    private array $URLParams;
    /**
     * @var Request $request 網站請求資訊
     */
    private Request $request;
    /**
     * @var array $MoreParams 更多的參數
     */
    private array $MoreParams;

    /**
     * @var string 客戶端指紋碼
     */
    private string $fingerprint;

    /**
     * @param I18N $i18N
     * @param array $URLParams
     * @param Request $request
     * @param array $MoreParams
     */
    public function __construct(I18N $i18N, array $URLParams, Request $request, array $MoreParams=[], string $fingerprint="")
    {
        $this->i18N = $i18N;
        $this->URLParams = $URLParams;
        $this->request = $request;
        $this->MoreParams = $MoreParams;
        $this->fingerprint = $fingerprint;
    }


    /**
     * @return I18N
     */
    public function getI18N(): I18N
    {
        return $this->i18N;
    }

    /**
     * @param I18N $i18N
     * @return CGLaravelControllerInit
     */
    public function setI18N(I18N $i18N): CGLaravelControllerInit
    {
        $this->i18N = $i18N;
        return $this;
    }

    /**
     * @return array
     */
    public function getURLParams(): array
    {
        return $this->URLParams;
    }

    /**
     * @param array $URLParams
     * @return CGLaravelControllerInit
     */
    public function setURLParams(array $URLParams): CGLaravelControllerInit
    {
        $this->URLParams = $URLParams;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return CGLaravelControllerInit
     */
    public function setRequest(Request $request): CGLaravelControllerInit
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return array
     */
    public function getMoreParams(): array
    {
        return $this->MoreParams;
    }

    public function addMoreParams(array ...$MoreParams): array
    {
        $array_merge = array_merge($this->MoreParams, ...$MoreParams);
        return $array_merge;
    }

    /**
     * @param array $MoreParams
     * @return CGLaravelControllerInit
     */
    public function setMoreParams(array $MoreParams): CGLaravelControllerInit
    {
        $this->MoreParams = $MoreParams;
        return $this;
    }

    public function toArrayable()
    {
        return [
            CGLaravelControllerInitEnum::urlParams->name => $this->getURLParams(),
            CGLaravelControllerInitEnum::i18N->name => $this->getI18N(),
            CGLaravelControllerInitEnum::moreParams->name => $this->getMoreParams(),
            CGLaravelControllerInitEnum::request->name => $this->getRequest(),
            CGLaravelControllerInitEnum::fingerprint->name => $this->getFingerprint(),
        ];
    }

    /**
     * @return string
     */
    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    /**
     * @param string $fingerprint
     * @return CGLaravelControllerInit
     */
    public function setFingerprint(string $fingerprint): CGLaravelControllerInit
    {
        $this->fingerprint = $fingerprint;
        return $this;
    }
}
