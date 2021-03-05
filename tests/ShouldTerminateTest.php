<?php

namespace Tests;

use Dyrynda\TerminableJobs\Exceptions\JobWasTerminated;
use Dyrynda\TerminableJobs\Terminable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShouldTerminateTest extends TestCase
{
    /**
     * @test
     * @covers \Dyrynda\TerminableJobs\Terminable
     **/
    public function it_should_not_execute_a_terminable_job()
    {
        config(['jobs.terminable-job.disabled' => true]);

        $this->expectException(JobWasTerminated::class);
        $this->expectExceptionMessage('The job `Tests\TerminableJob` was not run because `shouldTerminate()` returned `true`');

        $this->assertNull((new TerminableJob)->handle());
    }

    /**
     * @test
     * @covers \Dyrynda\TerminableJobs\Terminable
     **/
    public function it_should_execute_a_terminable_job()
    {
        config(['jobs.terminable-job.disabled' => false]);

        $this->assertEquals('Job was not terminated', (new TerminableJob)->handle());
    }
}

class TerminableJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, Terminable;

    public function handle()
    {
        $this->handleTermination();

        return 'Job was not terminated';
    }

    protected function shouldTerminate(): bool
    {
        return config('jobs.terminable-job.disabled');
    }
}
