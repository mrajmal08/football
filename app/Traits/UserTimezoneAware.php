<?php

namespace App\Traits;

use Auth;
use Config;
use DateTime;
use Datetimezone;
use Illuminate\Http\Request;

trait UserTimezoneAware
{
    /**
     * The attribute name containing the timezone (defaults to "timezone").
     *
     * @var string
     */
    public $timezoneAttribute = 'timezone';

    /**
     * Return the passed date in the user's timezone (or default to the app timezone)
     *
     * @return string
     */
    public function getDateToUserTimezone($date, $timezone = null)
    {
        if ($timezone == null) {
            if (Auth::check()) {
                $timezone = session('timezone');
            }
            //Check that it still isn't null (fallback incase session didn't work)
            if ($timezone == null) {
                $timezone = Config::get('app.fallback_user_timezone');
            }
        }

        $datetime = new DateTime($date);
        $datetime->setTimezone(new datetimezone($timezone));

        return $datetime->format('c');
    }
}
