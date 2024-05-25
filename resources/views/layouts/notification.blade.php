@use(App\Lib\I18N\ELanguageText)
@use(App\Lib\I18N\I18N;use App\Lib\Utils\ENotificationType)
@php
/***
 * @var string[] $urlParams
 * @var array $moreParams
 * @var I18N $i18N
 * @var Request $request
 */
@endphp
<div class="notification">
    <x-Notificationitem :title="$i18N->getLanguage(ELanguageText::notification_title)"
                        :description="$i18N->getLanguage(ELanguageText::notification_description)"
                        :type="ENotificationType::info"
                        :line=6
                        :millisecond=10000/>
    @if(session('custom_message')!==null and is_array(session('custom_message')))
        @if(session('custom_message')[0] !== null && session('custom_message')[1]!==null && session('custom_message')[2]!==null)
            <x-Notificationitem :title="session('custom_message')[0]"
                                :description="session('custom_message')[1]"
                                :type="session('custom_message')[2]"
                                :line=10/>
        @endif
    @endif
    @if(session('invaild') !== null)
        @php
            $title=$i18N->getLanguage(ELanguageText::notification_invaild_title);
            $description=$i18N->getLanguage(ELanguageText::notification_invaild_description);
            if(isset($errors)){
                if($errors->any()){
                    foreach ($errors->all() as $item) {
                        $description.="<br>".$item;
                    }
                }
            }
        @endphp
        <x-Notificationitem :type="ENotificationType::error"
                            :title="$title"
                            :description="$description"
                            :line=30/>
    @endif
    @if(session('mail') !== null)
        @php
            $title=$i18N->getLanguage(ELanguageText::notification_email_verifyTitle);
            $description="";
            $type= ENotificationType::info;
            if(session('mail') === true){
                $description = $i18N->getLanguage(ELanguageText::notification_email_description);
                $type= ENotificationType::success;
            }elseif(session('mail') === false){
                $description = $i18N->getLanguage(ELanguageText::notification_email_fail_description);
                $type= ENotificationType::error;
            }
        @endphp
        <x-Notificationitem :type="$type" :title="$title" :description="$description" :line=45/>
    @endif
    @if(session('mail_result') !== null)
        @php
            $title=$i18N->getLanguage(ELanguageText::notification_email_verifyTitle);
            $description="";
            $type= ENotificationType::info;
            if(session('mail_result') === 0){
                $description = $i18N->getLanguage(ELanguageText::notification_email_failedAppendText);
                $description .= $i18N->getLanguage(ELanguageText::notification_email_InvalidVerificationLink);
                $type= ENotificationType::error;
            }elseif(session('mail_result') === 1){
                $description = $i18N->getLanguage(ELanguageText::notification_email_failedAppendText);
                $description .= $i18N->getLanguage(ELanguageText::notification_email_hasVerifiedEmail);
                $type= ENotificationType::warning;
            }elseif(session('mail_result') === 2){
                $description = $i18N->getLanguage(ELanguageText::notification_email_markEmailAsVerified);
                $type= ENotificationType::success;
            }
        @endphp
        <x-Notificationitem :type="$type" :title="$title" :description="$description" :line=65/>
    @endif
</div>
