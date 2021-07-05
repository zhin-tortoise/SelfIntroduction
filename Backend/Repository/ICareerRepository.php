<?php

/**
 * 経歴リポジトリのインターフェース。
 */

interface ICareerRepository
{
    public function createCareer(CareerEntity $careerEntity): string;
}
