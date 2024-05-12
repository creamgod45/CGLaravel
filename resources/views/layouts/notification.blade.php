@use(App\Lib\I18N\ELanguageText;use App\Lib\Utils\ENotificationType)
<div class="notification">
    <x-notification-item :title="$i18N->getLanguage(ELanguageText::notification_title)"
                         :description="$i18N->getLanguage(ELanguageText::notification_description)"
                         :type="ENotificationType::warning"/>
    @if(session('custom_message')!==null and is_array(session('custom_message')))
        <x-notification-item :title="session('custom_message')[0]" :description="session('custom_message')[1]"
                             :type="session('custom_message')[2]"/>
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
        <x-notification-item :type="ENotificationType::error" :title="$title"
                             :description="$description"/>
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
        <x-notification-item :type="$type" :title="$title" :description="$description"/>
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
        <x-notification-item :type="$type" :title="$title" :description="$description"/>
    @endif
</div>
