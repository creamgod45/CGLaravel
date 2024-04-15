<?php

namespace App\Lib\I18N;

use App\Lib\Type\Array\CGArray;
use App\Lib\Type\String\CGString;
use App\Lib\Utils\Utils;
use Nette\Utils\FileSystem;
use Symfony\Component\Yaml\Yaml;

// https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry

class I18N implements II18N
{
    /**
     * @var ELanguageCode $languageCode 現在語系
     */
    private ELanguageCode $languageCode;

    /**
     * @var array $languageTextList 語言儲存容器
     */
    private array $languageTextList = [];

    /**
     * @var ELanguageCode[] $ELanguageCodeList 限制編譯編譯的語言選項
     */
    private array $ELanguageCodeList=[];

    /**
     * @param ELanguageCode|null $languageCode 設定現在語言狀態並且讀取語言檔案並覆蓋 Set the current language status and read the language file and overwrite it
     * @param bool $CompileMode 直接編譯模式(忽略沒有編譯過的詞條) Direct compilation mode (ignoring uncompiled entries)
     * @param ELanguageCode[] $limitMode 允許編譯的語言 Languages that allow compilation
     */
    public function __construct(?ELanguageCode $languageCode = null, bool $CompileMode= false, array $limitMode=[])
    {
        $this->ELanguageCodeList=$limitMode;
        $this->buildFirstLanguageFile($CompileMode, $limitMode);
        if ($languageCode !== null) {
            // 選擇語系
            $this->setLanguageCode($languageCode);
        } else {
            // 預設模式
        }
        $this->buildMissingLanguageDictionary($limitMode);
    }

    /**
     * @return ELanguageCode[]
     */
    public function getELanguageCodeList(): array
    {
        return $this->ELanguageCodeList;
    }

    /**
     * @param ELanguageCode[] $ELanguageCodeList
     * @return I18N
     */
    public function setELanguageCodeList(array $ELanguageCodeList): I18N
    {
        $this->ELanguageCodeList = $ELanguageCodeList;
        return $this;
    }

    /**
     * @param ELanguageCode[] $limitMode
     * @return void
     */
    public function buildMissingLanguageDictionary(array $limitMode=[]): void
    {
        $this->buildLanguageMap();
        if(!empty($limitMode)){
            $this->extracted($limitMode);
        }else{
            $this->extracted(ELanguageCode::cases());
        }
    }

    /**
     * @param $CompileMode
     * @param ELanguageCode[] $limitMode
     * @return void
     */
    public function buildFirstLanguageFile($CompileMode,array $limitMode=[]): void
    {
        if (file_exists("I18N.lock") && !$CompileMode) return;
        FileSystem::write("I18N.lock", time() . ": build I18N");
        $this->buildLanguageMap();
        $dump = Yaml::dump($this->languageTextList);
        if(!empty($limitMode)){
            foreach ($limitMode as $case) {
                FileSystem::write("lib/I18N/languages/" . $case->name . ".yml", $dump);
            }
        }else{
            foreach (ELanguageCode::cases() as $case) {
                FileSystem::write("lib/I18N/languages/" . $case->name . ".yml", $dump);
            }
        }
    }

    public function buildCustomizedMap()
    {
        new DictionaryMap($this);
    }

    public function buildLanguageMap(): void
    {
        $this->languageCodeDictionaryBuilder();
        $this->buildCustomizedMap();
    }

    public function languageCodeDictionaryBuilder(): void
    {
        $this->setLanguage(ELanguageText::af_ZA, "Afrikaans (South Africa)");
        $this->setLanguage(ELanguageText::am_ET, "Amharic (Ethiopia)");
        $this->setLanguage(ELanguageText::ar_EG, "Arabic (Egyptian)");
        $this->setLanguage(ELanguageText::ar_SA, "Arabic (Saudi Arabia)");
        $this->setLanguage(ELanguageText::as_IN, "Assamese (India)");
        $this->setLanguage(ELanguageText::ay_BO, "Aymara (Bolivia)");
        $this->setLanguage(ELanguageText::az_AZ, "Azerbaijani (Azerbaijan)");
        $this->setLanguage(ELanguageText::ba_RU, "Bashkir (Russian)");
        $this->setLanguage(ELanguageText::be_BY, "Belarusian (Belarus)");
        $this->setLanguage(ELanguageText::bg_BG, "Bulgarian (Bulgarian)");
        $this->setLanguage(ELanguageText::bn_IN, "Bengali (India)");
        $this->setLanguage(ELanguageText::bs_BA, "Bosnian (Bosnia and Herzegovina)");
        $this->setLanguage(ELanguageText::cr_CA, "Cree (Canada)");
        $this->setLanguage(ELanguageText::cs_CZ, "Czech (Czech Republic)");
        $this->setLanguage(ELanguageText::cy_GB, "Welsh (UK)");
        $this->setLanguage(ELanguageText::da_DK, "Danish (Denmark)");
        $this->setLanguage(ELanguageText::de_CH, "High German (Switzerland)");
        $this->setLanguage(ELanguageText::de_DE, "German (Germany)");
        $this->setLanguage(ELanguageText::dv_MV, "Dhivehi (Maldives)");
        $this->setLanguage(ELanguageText::dz_BT, "Dzongkha (Bhutan)");
        $this->setLanguage(ELanguageText::el_GR, "Greek (Greece)");
        $this->setLanguage(ELanguageText::en_AU, "English (Australia)");
        $this->setLanguage(ELanguageText::en_GB, "English (UK)");
        $this->setLanguage(ELanguageText::en_US, "English (US)");
        $this->setLanguage(ELanguageText::es_ES, "Spanish (Spain)");
        $this->setLanguage(ELanguageText::es_MX, "Spanish (Mexico)");
        $this->setLanguage(ELanguageText::et_EE, "Estonian (Estonia)");
        $this->setLanguage(ELanguageText::fa_IR, "Persian (Iran)");
        $this->setLanguage(ELanguageText::fi_FI, "Finnish (Finland)");
        $this->setLanguage(ELanguageText::fil_PH, "Tagalog (Philippines)");
        $this->setLanguage(ELanguageText::fj_FJ, "Fijian (Fiji)");
        $this->setLanguage(ELanguageText::fo_FO, "Faroe (Faroe Islands)");
        $this->setLanguage(ELanguageText::fr_BE, "French (Belgium)");
        $this->setLanguage(ELanguageText::fr_CA, "French (Canada)");
        $this->setLanguage(ELanguageText::fr_FR, "French (France)");
        $this->setLanguage(ELanguageText::ga_IE, "Irish (Ireland)");
        $this->setLanguage(ELanguageText::gd_GB, "Scottish Gaelic (UK)");
        $this->setLanguage(ELanguageText::gil_KI, "Gibbert (Giribati)");
        $this->setLanguage(ELanguageText::gu_IN, "Gujarati (India)");
        $this->setLanguage(ELanguageText::ha_NG, "Hausa (Nigeria)");
        $this->setLanguage(ELanguageText::he_IL, "Hebrew (Israel)");
        $this->setLanguage(ELanguageText::hi_IN, "Hindi (India)");
        $this->setLanguage(ELanguageText::hr_HR, "Croatian (Croatia)");
        $this->setLanguage(ELanguageText::hu_HU, "Hungarian (Hungary)");
        $this->setLanguage(ELanguageText::hy_AM, "Armenian (Armenian)");
        $this->setLanguage(ELanguageText::ibb_NG, "Ibibio (Nigeria)");
        $this->setLanguage(ELanguageText::id_ID, "Bahasa Indonesia (Indonesia)");
        $this->setLanguage(ELanguageText::ig_NG, "Igbo (Nigeria)");
        $this->setLanguage(ELanguageText::is_IS, "Icelandic (Iceland)");
        $this->setLanguage(ELanguageText::it_IT, "Italian (Italian)");
        $this->setLanguage(ELanguageText::iu_CA, "Inuktitut (Canada)");
        $this->setLanguage(ELanguageText::ja_JP, "Japanese (Japan)");
        $this->setLanguage(ELanguageText::ka_GE, "Georgian (Georgia)");
        $this->setLanguage(ELanguageText::kk_KZ, "Kazakh (Kazakh)");
        $this->setLanguage(ELanguageText::km_KH, "Khmer (Cambodia)");
        $this->setLanguage(ELanguageText::kn_IN, "Kannada (India)");
        $this->setLanguage(ELanguageText::ko_KP, "Korean (North Korea)");
        $this->setLanguage(ELanguageText::ko_KR, "Korean (South Korea)");
        $this->setLanguage(ELanguageText::ku_TR, "Kurdish (Türkiye)");
        $this->setLanguage(ELanguageText::kw_GB, "Cornish (UK)");
        $this->setLanguage(ELanguageText::ky_KG, "Kyrgyz (Kyrgyz)");
        $this->setLanguage(ELanguageText::ln_CD, "Lingala (Democratic Republic of Congo)");
        $this->setLanguage(ELanguageText::lo_LA, "Lao language (Laos)");
        $this->setLanguage(ELanguageText::lt_LT, "Lithuanian (Lithuania)");
        $this->setLanguage(ELanguageText::lv_LV, "Latvian (Latvian)");
        $this->setLanguage(ELanguageText::mg_MG, "Malagasy (Madagascar)");
        $this->setLanguage(ELanguageText::mh_MH, "Marshallese (Marshall Islands)");
        $this->setLanguage(ELanguageText::mi_NZ, "Maori (New Zealand)");
        $this->setLanguage(ELanguageText::mk_MK, "Macedonian (North Macedonia)");
        $this->setLanguage(ELanguageText::ml_IN, "Malayalam (India)");
        $this->setLanguage(ELanguageText::mn_MN, "Mongolian (Mongolia)");
        $this->setLanguage(ELanguageText::mn_Mong_CN, "Mongolian (Mongolian script, China)");
        $this->setLanguage(ELanguageText::mr_IN, "Marathi (India)");
        $this->setLanguage(ELanguageText::ms_MY, "Malay (Malaysia)");
        $this->setLanguage(ELanguageText::mt_MT, "Maltese (Malta)");
        $this->setLanguage(ELanguageText::my_MM, "Burmese (Myanmar)");
        $this->setLanguage(ELanguageText::na_NR, "Nauru (Nauru)");
        $this->setLanguage(ELanguageText::ne_NP, "Nepali (Nepal)");
        $this->setLanguage(ELanguageText::nl_NL, "Dutch (Netherlands)");
        $this->setLanguage(ELanguageText::no_NO, "Norwegian (Norway)");
        $this->setLanguage(ELanguageText::ny_MW, "Chichewa (Malawi)");
        $this->setLanguage(ELanguageText::oj_CA, "Ojibway (Canada)");
        $this->setLanguage(ELanguageText::or_IN, "Oriya (India)");
        $this->setLanguage(ELanguageText::pa_Arab_PK, "Punjabi (Arabic script, Pakistan)");
        $this->setLanguage(ELanguageText::pa_IN, "Punjabi (India)");
        $this->setLanguage(ELanguageText::pl_PL, "Polish (Polish)");
        $this->setLanguage(ELanguageText::ps_AF, "Pashto (Afghanistan)");
        $this->setLanguage(ELanguageText::pt_BR, "Portuguese (Brazil)");
        $this->setLanguage(ELanguageText::pt_PT, "Portuguese (Portugal)");
        $this->setLanguage(ELanguageText::qu_PE, "Quechua (Peru)");
        $this->setLanguage(ELanguageText::ro_RO, "Romanian (Romania)");
        $this->setLanguage(ELanguageText::ru_RU, "Russian (Russia)");
        $this->setLanguage(ELanguageText::rw_RW, "Rwanda (Rwanda)");
        $this->setLanguage(ELanguageText::sa_IN, "Sanskrit (India)");
        $this->setLanguage(ELanguageText::sd_Deva_IN, "Sindhi (Devava, India)");
        $this->setLanguage(ELanguageText::sd_PK, "Sindhi (Pakistan)");
        $this->setLanguage(ELanguageText::si_LK, "Sinhala (Sri Lanka)");
        $this->setLanguage(ELanguageText::sk_SK, "Slovak (Slovakia)");
        $this->setLanguage(ELanguageText::sl_SI, "Slovenian (Slovenia)");
        $this->setLanguage(ELanguageText::sm_WS, "Samoan (Samoan)");
        $this->setLanguage(ELanguageText::sn_ZW, "Shona (Zimbawi)");
        $this->setLanguage(ELanguageText::so_DJ, "Somali (Djibouti)");
        $this->setLanguage(ELanguageText::so_SO, "Somali (Somalia)");
        $this->setLanguage(ELanguageText::sq_AL, "Albanian (Albania)");
        $this->setLanguage(ELanguageText::sr_RS, "Serbian (Serbia)");
        $this->setLanguage(ELanguageText::ss_SZ, "Swati (Swaziland)");
        $this->setLanguage(ELanguageText::st_ZA, "Southern Sotho (South Africa)");
        $this->setLanguage(ELanguageText::sv_SE, "Swedish (Sweden)");
        $this->setLanguage(ELanguageText::sw_KE, "Swahili (Kenya)");
        $this->setLanguage(ELanguageText::syr_SY, "Syriac (Syria)");
        $this->setLanguage(ELanguageText::ta_IN, "Tamil (India)");
        $this->setLanguage(ELanguageText::te_IN, "Telugu (India)");
        $this->setLanguage(ELanguageText::tg_TJ, "Tajik (Tajikistan)");
        $this->setLanguage(ELanguageText::th_TH, "Thai (Thailand)");
        $this->setLanguage(ELanguageText::ti_ER, "Tigrinya (Eritrea)");
        $this->setLanguage(ELanguageText::ti_ET, "Tigrinya (Ethiopia)");
        $this->setLanguage(ELanguageText::tj_TJ, "Tajik (Tajikistan)");
        $this->setLanguage(ELanguageText::tk_TM, "Turkmen (Turkmenistan)");
        $this->setLanguage(ELanguageText::tl_PH, "Tagalog (Philippines)");
        $this->setLanguage(ELanguageText::tn_BW, "Tswana (Botswana)");
        $this->setLanguage(ELanguageText::to_TO, "Tongan (Tongan)");
        $this->setLanguage(ELanguageText::tr_TR, "Turkish (Türkiye)");
        $this->setLanguage(ELanguageText::tt_RU, "Tatar (Russian)");
        $this->setLanguage(ELanguageText::tum_MW, "Tumbuka (Malawi)");
        $this->setLanguage(ELanguageText::ty_PF, "Tahiti (French Polynesia)");
        $this->setLanguage(ELanguageText::udm_RU, "Udmurt (Russian)");
        $this->setLanguage(ELanguageText::ug_CN, "Uyghur (China)");
        $this->setLanguage(ELanguageText::uk_UA, "Ukrainian (Ukraine)");
        $this->setLanguage(ELanguageText::ur_PK, "Urdu (Pakistan)");
        $this->setLanguage(ELanguageText::uz_UZ, "Uzbek (Uzbek)");
        $this->setLanguage(ELanguageText::ve_ZA, "Venda (South Africa)");
        $this->setLanguage(ELanguageText::vi_VN, "Vietnamese (Vietnam)");
        $this->setLanguage(ELanguageText::xh_ZA, "Xhosa (South Africa)");
        $this->setLanguage(ELanguageText::yo_NG, "Yoruba (Nigeria)");
        $this->setLanguage(ELanguageText::zh_CN, "Simplified Chinese (China)");
        $this->setLanguage(ELanguageText::zh_TW, "Traditional Chinese (Taiwan)");
        $this->setLanguage(ELanguageText::zh_HK, "Traditional Chinese (Hong Kong)");
        $this->setLanguage(ELanguageText::zh_SG, "Traditional Chinese (Singapore)");
        $this->setLanguage(ELanguageText::zh_MO, "Traditional Chinese (Singapore)");
        $this->setLanguage(ELanguageText::zu_ZA, "Zulu (South Africa)");
    }

    public function setLanguage(ELanguageText $elanguageText, string $value): static
    {
        $this->languageTextList[$elanguageText->name] = $value;
        return $this;
    }

    /**
     * @return ELanguageCode
     */
    public function getLanguageCode(): ELanguageCode
    {
        return $this->languageCode;
    }


    public function setLanguageCode(ELanguageCode $languageCode): static
    {
        $this->languageCode = $languageCode;
        $this->reSelectLanguageFile();
        return $this;
    }

    /**
     * @param ELanguageCode[] $ELanguageCodeList
     * @return void
     */
    private function extracted(array $ELanguageCodeList): void
    {
        foreach ($ELanguageCodeList as $case) {
            if (!file_exists("lib/I18N/languages/" . $case->name . ".yml")) {
                Utils::pinv("1");
                $dump = Yaml::dump($this->languageTextList);
                FileSystem::write("lib/I18N/languages/" . $case->name . ".yml", $dump);
                continue;
            }
            $languageYaml = $this->yamlController("lib/I18N/languages/" . $case->name . ".yml");
            //Utils::pinv($languageYaml, "before: ".$case->name);
            $change = 0;
            $cgkeys = new CGArray($languageYaml);
            foreach ($this->languageTextList as $key => $c) {
                if (!$cgkeys->hasKey($key)) {
                    $languageYaml[$key] = $this->languageTextList[$key];
                    $change++;
                }
            }
            //Utils::pinv($languageYaml, "after: ".$case->name);
            if ($change > 0) {
                Utils::pinv($change, "2");
                $dump = Yaml::dump($languageYaml);
                FileSystem::write("lib/I18N/languages/" . $case->name . ".yml", $dump);
            }
        }
    }

    private function reSelectLanguageFile(): void
    {
        if (file_exists("lib/I18N/languages/" . $this->languageCode->name . ".yml")) {
            $lang = $this->yamlController("lib/I18N/languages/" . $this->languageCode->name . ".yml");
            $this->setLanguageTextList($lang);
        }
    }

    /**
     * @param $filename
     * @param int $flag
     * @return mixed
     */
    public function yamlController($filename, int $flag = 0): mixed
    {
        return Yaml::parseFile($filename, $flag);
    }

    /**
     * @return array
     */
    public function getLanguageTextList(): array
    {
        return $this->languageTextList;
    }


    /**
     * @param array $languageTextList
     * @return $this
     */
    public function setLanguageTextList(array $languageTextList): static
    {
        $this->languageTextList = $languageTextList;
        return $this;
    }

    /**
     * @param ELanguageText $elanguageText
     * @param bool $toCGString
     * @return mixed|CGString|null
     */
    public function getLanguage(ELanguageText $elanguageText, bool $toCGString = false): mixed
    {
        if (empty($this->languageTextList)) return null;
        if (empty($this->languageTextList[$elanguageText->name])) return null;
        if ($toCGString) {
            return new CGString($this->languageTextList[$elanguageText->name]);
        } else {
            return $this->languageTextList[$elanguageText->name];
        }
    }


}
