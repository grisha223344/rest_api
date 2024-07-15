<?php

namespace App\Repositories\UserRepository;

use Illuminate\Database\Eloquent\Builder;

class UserRepositoryQuery
{
    public Builder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function whenId($id): UserRepositoryQuery
    {
        $this->query->when($id, function(Builder $query, $id) {
            return $query->where('id', $id);
        });

        return $this;
    }

    public function whenName($name): UserRepositoryQuery
    {
        $this->query->when($name, function(Builder $query, $name) {
            return $query->where('name', $name);
        });

        return $this;
    }

    public function whenMiddleName($middle_name): UserRepositoryQuery
    {
        $this->query->when($middle_name, function(Builder $query, $middle_name) {
            return $query->where('middle_name', $middle_name);
        });

        return $this;
    }

    public function whenLastName($last_name): UserRepositoryQuery
    {
        $this->query->when($last_name, function(Builder $query, $last_name) {
            return $query->where('last_name', $last_name);
        });

        return $this;
    }

    public function whenPhone($phone): UserRepositoryQuery
    {
        $this->query->when($phone, function(Builder $query, $phone) {
            return $query->where('phone', $phone);
        });

        return $this;
    }

    public function whenEmail($email): UserRepositoryQuery
    {
        $this->query->when($email, function(Builder $query, $email) {
            return $query->where('email', $email);
        });

        return $this;
    }
}
