<?php
/**
 * Date: 2019-12-03
 * Time: 14:17
 */

class User implements JsonSerializable
{
    protected int $id;
    protected string $username;
    protected int $sex;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getSex(): ?int
    {
        return $this->sex;
    }

    public function setSex(int $sex): self
    {
        $this->sex = $sex;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'sex' => $this->sex,
            'username' => $this->username
        ];
    }
}

