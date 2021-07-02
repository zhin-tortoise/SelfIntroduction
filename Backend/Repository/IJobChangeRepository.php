<?php

/**
 * 転職事由リポジトリのインターフェース。
 */

interface IJobChangeRepository
{
    public function createJobChange(JobChangeEntity $jobChangeEntity): string;
}
