<?php

namespace App\Lib\Utils;

use App\Lib\I18N\ELanguageCode;

class ClientConfig
{
    private ELanguageCode $languageClass;
    private string $language;

    /**
     * @return ELanguageCode
     */
    public function getLanguageClass(): ELanguageCode
    {
        return $this->languageClass;
    }

    /**
     * @param ELanguageCode $languageClass
     * @return ClientConfig
     */
    public function setLanguageClass(ELanguageCode $languageClass): ClientConfig
    {
        $this->languageClass = $languageClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return ClientConfig
     */
    public function setLanguage(string $language): ClientConfig
    {
        $this->language = $language;
        return $this;
    }

    public function __construct(string $language="en_US")
    {
        if (ELanguageCode::isVaild($language)) {
            $this->language = $language;
            $this->languageClass = ELanguageCode::valueof($language);
        }
    }
}
