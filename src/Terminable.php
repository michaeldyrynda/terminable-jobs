<?php

namespace Dyrynda\TerminableJobs;

use Dyrynda\TerminableJobs\Exceptions\JobWasTerminated;

trait Terminable
{
    protected function handleTermination(): void
    {
        if ($this->shouldTerminate()) {
            $this->delete();

            throw JobWasTerminated::shouldTerminate(static::class);

            return;
        }
    }

    abstract protected function shouldTerminate(): bool;
}
