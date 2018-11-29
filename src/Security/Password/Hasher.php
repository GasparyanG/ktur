<?php
namespace Security\Password;

class Hasher
{
    private $algorithm = "sha1";

    public function hashPassword(string $password): array
    {
        $salt = $this->getSalt($password);
        $passwordAndSalt = $password . $salt;
        $hashedPassword = hash($this->algorithm, $passwordAndSalt);

        return [$hashedPassword, $salt];
    }

    private function getSalt(string $password): string
    {
        $shuffledPassword = str_shuffle($password);
        $salt = hash($this->algorithm, $shuffledPassword);

        return $salt;
    }
}