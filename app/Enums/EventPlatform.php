<?php

namespace App\Enums;

enum EventPlatform
{
    public const ZOOM = 'Zoom';
    public const GOOGLE_MEET = 'Google Meet';
    public const MICROSOFT_TEAMS = 'Microsoft Teams';
    public const WEBEX = 'Webex';
    public const FACEBOOK_LIVE = 'Facebook Live';
    public const YOUTUBE_LIVE = 'YouTube Live';
    public const INSTAGRAM_LIVE = 'Instagram Live';
    public const TWITCH = 'Twitch';
    public const DISCORD = 'Discord';
    public const LINKEDIN_LIVE = 'LinkedIn Live';
    public const CUSTOM_URL = 'Custom URL';
    public const BLUEJEANS = 'BlueJeans';
    public const GOTOMEETING = 'GoToMeeting';
    public const HOPIN = 'Hopin';
    public const SKYPE = 'Skype';
    public const SLACK = 'Slack';
    public const VIMEO_LIVE = 'Vimeo Live';
    public const DAILYMOTION = 'Dailymotion';
    public const PERISCOPE = 'Periscope';
    public const MIXER = 'Mixer';
    public const CLICKMEETING = 'ClickMeeting';
    public const CROWDCAST = 'Crowdcast';
    public const BRIGHTTALK = 'BrightTALK';
    public const BIGMARKER = 'BigMarker';
    public const STREAMYARD = 'StreamYard';
    public const JITSI_MEET = 'Jitsi Meet';
    public const BE_LIVE = 'Be.Live';
    public const LOOM = 'Loom';
    public const RESTREAM = 'Restream';
    public const ZOOM_WEBINAR = 'Zoom Webinar';
    public const TEAMS_LIVE = 'Teams Live';
    public const WHOVA = 'Whova';
    public const AIRMEET = 'Airmeet';
    public const REMO = 'Remo';
    public const INXPO = 'INXPO';
    public const ON24 = 'ON24';
    public const VFAIRS = 'vFairs';
    public const BRELLA = 'Brella';
    public const RUN_THE_WORLD = 'Run The World';
    public const KUDO = 'KUDO';
    public const INTERPREFY = 'Interprefy';
    public const YELLOWDUCK = 'YellowDuck';
    public const QIQO_CHAT = 'QiQo Chat';
    public const STAGEIT = 'StageIt';
    public const VEVO = 'Vevo';
    public const GEEX = 'Geex';
    public const INTERCALL = 'InterCall';
    public const NEXTSTREAM = 'NextStream';
    public const TWITTER_LIVE = 'Twitter Live';
    public const EVENTMOBI = 'EventMobi';
    public const WOWZA = 'Wowza';

    /**
     * Get all platform options.
     *
     * @return array
     */
    public static function getOptions()
    {
        return [
            self::ZOOM,
            self::GOOGLE_MEET,
            self::MICROSOFT_TEAMS,
            self::WEBEX,
            self::FACEBOOK_LIVE,
            self::YOUTUBE_LIVE,
            self::INSTAGRAM_LIVE,
            self::TWITCH,
            self::DISCORD,
            self::LINKEDIN_LIVE,
            self::CUSTOM_URL,
            self::BLUEJEANS,
            self::GOTOMEETING,
            self::HOPIN,
            self::SKYPE,
            self::SLACK,
            self::VIMEO_LIVE,
            self::DAILYMOTION,
            self::PERISCOPE,
            self::MIXER,
            self::CLICKMEETING,
            self::CROWDCAST,
            self::BRIGHTTALK,
            self::BIGMARKER,
            self::STREAMYARD,
            self::JITSI_MEET,
            self::BE_LIVE,
            self::LOOM,
            self::RESTREAM,
            self::ZOOM_WEBINAR,
            self::TEAMS_LIVE,
            self::WHOVA,
            self::AIRMEET,
            self::REMO,
            self::INXPO,
            self::ON24,
            self::VFAIRS,
            self::BRELLA,
            self::RUN_THE_WORLD,
            self::KUDO,
            self::INTERPREFY,
            self::YELLOWDUCK,
            self::QIQO_CHAT,
            self::STAGEIT,
            self::VEVO,
            self::GEEX,
            self::INTERCALL,
            self::NEXTSTREAM,
            self::TWITTER_LIVE,
            self::EVENTMOBI,
            self::WOWZA,
        ];
    }

    /**
     * Validate a given platform.
     *
     * @param string $platform
     * @return bool
     */
    public static function isValid($platform)
    {
        return in_array($platform, self::getOptions());
    }
}
