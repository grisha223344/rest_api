<?php

namespace App\DTO;

class FilterDataUserDTO
{
    public ?string $id;
    public ?string $last_name;
    public ?string $name;
    public ?string $middle_name;
    public ?string $phone;
    public ?string $email;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->last_name = $data->last_name;
        $this->name = $data->name;
        $this->middle_name = $data->middle_name;
        $this->phone = $data->phone;
        $this->email = $data->email;
    }
}
