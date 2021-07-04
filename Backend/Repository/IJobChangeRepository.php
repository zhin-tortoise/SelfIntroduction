<?php

/**
 * 転職事由リポジトリのインターフェース。
 */

interface IJobChangeRepository
{
    public function createJobChange(JobChangeEntity $jobChangeEntity): string;
    public function readJobChangeFromUserId(int $userId);
    public function readAllJobChange(): array;
    public function updateJobChange(JobChangeEntity $jobChangeEntity): string;
    public function deleteJobChange(JobChangeEntity $jobChangeEntity): string;
}
