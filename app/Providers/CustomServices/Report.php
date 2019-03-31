<?php

namespace App\Providers\CustomServices;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class Report
{
    protected static $noFlash = [
        'password',
        'passwordOld',
        'passwordVerify',
        'currentPassword',
        'newPassword',
        'confirmNewPassword',
    ];

    public static function register()
    {
        Bugsnag::registerCallback(function ($report) {
            $context = $report->getMetaData();
            if (!empty($context['request']['params']['query'])) {
                $query = $context['request']['params']['query'];
                $context['request']['params']['query'] = Report::updateDataQuery($query);
                $report->setMetaData($context, false);
            }
        });
    }

    private static function updateDataQuery($query)
    {
        foreach (Report::$noFlash as $value) {
            $posValue = strpos($query, $value);
            if ($posValue > 0) {
                $valueStart = strpos($query, '"', $posValue) + 1;
                $valueEnd = strpos($query, '"', $valueStart);
                $valueLenght = $valueEnd - $valueStart;
                $query = substr_replace($query, "[noflash]", $valueStart, $valueLenght);
            }
        }
        return $query;
    }
}