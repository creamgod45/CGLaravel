<?php

namespace App\Lib\Utils;

use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ValidatorBuilder
{
    private I18N $i18N;
    private array $rules;
    private array $customMessages;
    private array $atters;

    public function __construct(I18N $i18N, EValidatorType $eValidatorType = EValidatorType::NULL)
    {
        $this->i18N = $i18N;
        switch ($eValidatorType) {
            case EValidatorType::LOGIN:
                $this->login();
                break;
            case EValidatorType::REGISTER:
                $this->register();
                break;
            case EValidatorType::FORGOTPASSWORD:
                $this->forgotpassword();
                break;
            case EValidatorType::RESETPASSWORD:
                $this->resetpassword();
                break;
            case EValidatorType::RESETPASSWORDPOST:
                $this->resetpasswordpost();
                break;
            case EValidatorType::ANIMALCREATE:
                $this->animalcreate();
                break;
            case EValidatorType::NULL:
                break;
        }
    }

    private function login()
    {
        $this->customMessages = $this->initMessage();
        $this->atters = $this->initAtters();
        $this->rules = [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    private function forgotpassword(){
        $this->customMessages = $this->initMessage();
        $this->atters = $this->initAtters();
        $this->rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }

    private function resetpassword()
    {
        $this->customMessages = $this->initMessage();
        $this->atters = $this->initAtters();
        $this->rules = [
            'token' => 'required',
            'email' => 'required|email'
        ];
    }

    private function resetpasswordpost()
    {
        $this->customMessages = $this->initMessage();
        $this->atters = $this->initAtters();
        $this->rules = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    private function register()
    {
        $this->customMessages = $this->initMessage();
        $this->atters = $this->initAtters();
        $this->rules = [
            'username' => ['required', 'string', 'max:255', 'unique:members'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'min:10', 'max:255', 'unique:members'],
        ];
    }

    /**
     * @param $data
     * @return array|MessageBag
     */
    public function validate($data)
    {
        //debugbar()->info($data);
        $validator = Validator::make($data, $this->getRules(), $this->getCustomMessages(), $this->getAtters());
        if ($validator->fails()) return $validator->errors();
        return $validator->validate();
    }


    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getCustomMessages(): array
    {
        return $this->customMessages;
    }

    /**
     * @return array
     */
    public function getAtters(): array
    {
        return $this->atters;
    }

    private function initAtters()
    {
        return [
            'username' => $this->i18N->getLanguage(ELanguageText::validator_field_username),
            'email' => $this->i18N->getLanguage(ELanguageText::validator_field_email),
            'password' => $this->i18N->getLanguage(ELanguageText::validator_field_password),
            'phone' => $this->i18N->getLanguage(ELanguageText::validator_field_phone),
            'token' => $this->i18N->getLanguage(ELanguageText::validator_field_token),
        ];
    }

    private function initMessage()
    {
        $arr = [
            'accepted'        => 'validator_accepted',
            'accepted_if'     => 'validator_accepted_if',
            'active_url'      => 'validator_active_url',
            'after'           => 'validator_after',
            'after_or_equal'  => 'validator_after_or_equal',
            'alpha'           => 'validator_alpha',
            'alpha_dash'      => 'validator_alpha_dash',
            'alpha_num'       => 'validator_alpha_num ',
            'array'           => 'validator_array',
            'ascii'           => 'validator_ascii',
            'before'          => 'validator_before',
            'before_or_equal' => 'validator_before_or_equal',
            'between'         => [
                'array'   => 'validator_between_array',
                'file'    => 'validator_between_file',
                'numeric' => 'validator_between_numeric',
                'string'  => 'validator_between_string',
            ],
            'boolean'           => 'validator_boolean',
            'can'               => 'validator_can',
            'confirmed'         => $this->i18N->getLanguage(ELanguageText::validator_confirmed, true)->Replace("%validator_field_passwordConfirmed%", $this->i18N->getLanguage(ELanguageText::validator_field_passwordConfirmed))->toString(),
            'current_password'  => 'validator_current_password',
            'date'              => 'validator_date',
            'date_equals'       => 'validator_date_equals',
            'date_format'       => 'validator_date_format',
            'decimal'           => 'validator_decimal',
            'declined'          => 'validator_declined',
            'declined_if'       => 'validator_declined_if',
            'different'         => 'validator_different',
            'digits'            => 'validator_digits',
            'digits_between'    => 'validator_digits_between',
            'dimensions'        => 'validator_dimensions',
            'distinct'          => 'validator_distinct',
            'doesnt_end_with'   => 'validator_doesnt_end_with',
            'doesnt_start_with' => 'validator_doesnt_start_with',
            'email'             => 'validator_email',
            'ends_with'         => 'validator_ends_with',
            'enum'              => 'validator_enum',
            'exists'            => 'validator_exists',
            'extensions'        => 'validator_extensions',
            'file'              => 'validator_file',
            'filled'            => 'validator_filled',
            'gt'                => [
                'array'   => 'validator_gt_array',
                'file'    => 'validator_gt_file',
                'numeric' => 'validator_gt_numeric',
                'string'  => 'validator_gt_string',
            ],
            'gte' => [
                'array'   => 'validator_gte_array',
                'file'    => 'validator_gte_file',
                'numeric' => 'validator_gte_numeric',
                'string'  => 'validator_gte_string',
            ],
            'hex_color' => 'validator_hex_color',
            'image'     => 'validator_image',
            'in'        => 'validator_in',
            'in_array'  => 'validator_in_array',
            'integer'   => 'validator_integer',
            'ip'        => 'validator_ip',
            'ipv4'      => 'validator_ipv4',
            'ipv6'      => 'validator_ipv6',
            'json'      => 'validator_json',
            'lowercase' => 'validator_lowercase',
            'lt'        => [
                'array'   => 'validator_lt_array',
                'file'    => 'validator_lt_file',
                'numeric' => 'validator_lt_numeric',
                'string'  => 'validator_lt_string',
            ],
            'lte'       => [
                'array'   => 'validator_lte_array',
                'file'    => 'validator_lte_file',
                'numeric' => 'validator_lte_numeric',
                'string'  => 'validator_lte_string',

            ],
            'mac_address' => 'validator_mac_address',
            'max'         => [
                 'array'   => 'validator_max_array',
                 'file'    => 'validator_max_file',
                 'numeric' => 'validator_max',
                 'string'  => 'validator_max_string',
            ],
            'max_digits' => 'validator_max_digits',
            'mimes'      => 'validator_mimes',
            'mimetypes'  => 'validator_mimetypes',
            'min'        => [
                'array'   => 'validator_min_array',
                'file'    => 'validator_min_file',
                'numeric' => 'validator_min',
                'string'  => 'validator_min_string',
            ],
            'min_digits'       => 'validator_min_digits',
            'missing'          => 'validator_missing',
            'missing_if'       => 'validator_missing_if',
            'missing_unless'   => 'validator_missing_unless',
            'missing_with'     => 'validator_missing_with',
            'missing_with_all' => 'validator_missing_with_all',
            'multiple_of'      => 'validator_multiple_of',
            'not_in'           => 'validator_not_in',
            'not_regex'        => 'validator_not_regex',
            'numeric'          => 'validator_numeric',
            'password'         => [
                'letters'       => 'validator_password_letters',
                'mixed'         => 'validator_password_mixed',
                'numbers'       => 'validator_password_numbers',
                'symbols'       => 'validator_password_symbols',
                'uncompromised' => 'validator_password_uncompromised',
            ],
            'present'              => 'validator_present',
            'present_if'           => 'validator_present_if',
            'present_unless'       => 'validator_present_unless',
            'present_with'         => 'validator_present_with',
            'present_with_all'     => 'validator_present_with_all',
            'prohibited'           => 'validator_prohibited',
            'prohibited_if'        => 'validator_prohibited_if',
            'prohibited_unless'    => 'validator_prohibited_unless',
            'prohibits'            => 'validator_prohibits',
            'regex'                => 'validator_regex',
            'required'             => 'validator_required',
            'required_array_keys'  => 'validator_required_array_keys',
            'required_if'          => 'validator_required_if',
            'required_if_accepted' => 'validator_required_if_accepted',
            'required_unless'      => 'validator_required_unless',
            'required_with'        => 'validator_required_with',
            'required_with_all'    => 'validator_required_with_all',
            'required_without'     => 'validator_required_without',
            'required_without_all' => 'validator_required_without_all',
            'same'                 => 'validator_same',
            'size'                 => [
                'array'   => 'validator_size_array',
                'file'    => 'validator_size_file',
                'numeric' => 'validator_size_numeric',
                'string'  => 'validator_size_string',
            ],
            'starts_with' => 'validator_starts_with',
            'string'      => 'validator_string',
            'timezone'    => 'validator_timezone',
            'unique'      => 'validator_unique',
            'uploaded'    => 'validator_uploaded',
            'uppercase'   => 'validator_uppercase',
            'url'         => 'validator_url',
            'ulid'        => 'validator_ulid',
            'uuid'        => 'validator_uuid',

        ];
        $newarr = [];
        foreach ($arr as $key => $item) {
            if(is_array($item)){
                foreach ($item as $k => $v) {
                    $isELanguageText = ELanguageText::valueof($v);
                    if($isELanguageText===null){
                        $newarr [$key][$k] = $v;
                    }else{
                        $newarr [$key][$k] = $this->i18N->getLanguage($isELanguageText);
                    }
                }
            }else{
                $isELanguageText = ELanguageText::valueof($item);
                if($isELanguageText===null){
                    $newarr [$key] = $item;
                }else{
                    $newarr [$key] = $this->i18N->getLanguage($isELanguageText);
                }
            }
        }
        return $newarr;
    }

    private function animalcreate()
    {
        $this->customMessages = $this->initMessage();
        $this->atters = $this->initAtters();
        $this->rules = [
            'type_id' => ['required', 'numeric', 'max:10', 'unique:animals'],
            'name' => ['required', 'string', 'max:255'],
            'birthday' => ['date','nullable'],
            'area' => ['string', 'max:255','nullable'],
            'fix' => ['required', 'max:1', 'max_digits:1', 'min_digits:0'],
            'description' => ['string','nullable'],
            'personality' => ['string','nullable'],
        ];
    }

}