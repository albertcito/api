<?php
namespace App\Exceptions;

use GraphQL\Error\Error;
use Rebing\GraphQL\Error\ValidationError;
use App\Exceptions\MessageError;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class GraphQLExceptions
{
    public static function formatError(Error $e)
    {
        $error = [
            'message' => $e->getMessage()
        ];

        $previous = $e->getPrevious();
        if ($previous) {
            if ($previous instanceof ValidationError) {
                $error['validation'] = $previous->getValidatorMessages();
            } elseif (!($previous instanceof MessageError)) {
                if (\App::environment() == 'production') {
                    $error['message'] = __('graphql.error500');
                } else {
                    $error['code'] = $e->getCode();
                    $error['line'] = $e->getPrevious()->getLine();
                    $error['file'] = $e->getPrevious()->getFile();
                    $error['class'] = class_basename($e->getPrevious());
                    $error['trace'] = collect($e->getPrevious()->getTrace())->map(function ($trace) {
                        return Arr::except($trace, ['args']);
                    })->all();
                }
                Bugsnag::notifyException($e->getPrevious());
            }
        }

        return $error;
    }
}
