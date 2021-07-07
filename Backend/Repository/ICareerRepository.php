<?php

/**
 * 経歴リポジトリのインターフェース。
 */

interface ICareerRepository
{
    public function createCareer(CareerEntity $careerEntity): string;
    public function readCareerFromId(int $id);
    public function readCareerFromUserId(int $userId): array;
    public function readAllCareer(): array;
    public function updateCareer(CareerEntity $careerEntity): string;
    public function deleteCareer(CareerEntity $careerEntity): string;
}
