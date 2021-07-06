<?php

/**
 * 経歴リポジトリのインターフェース。
 */

interface ICareerRepository
{
    public function createCareer(CareerEntity $careerEntity): string;
    public function deleteCareer(CareerEntity $careerEntity): string;
}
