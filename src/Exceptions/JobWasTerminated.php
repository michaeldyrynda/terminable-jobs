<?php

namespace Dyrynda\TerminableJobs\Exceptions;

use RuntimeException;

class JobWasTerminated extends RuntimeException
{
    public static function shouldTerminate(string $class)
    {
        return new static("The job `{$class}` was not run because `shouldTerminate()` returned `true`");
    }
}
