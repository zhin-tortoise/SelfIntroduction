<?php

/**
 * 転職事由リポジトリのインターフェース。
 */

interface IJobChangeRepository
{
    public function createJobChange(JobChangeEntity $jobChangeEntity): string;
    public function readJobChangeFromId(int $id);
    public function readAllJobChange(): array;
    public function deleteJobChange(JobChangeEntity $jobChangeEntity): string;
}
