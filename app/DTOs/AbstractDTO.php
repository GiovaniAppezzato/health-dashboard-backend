<?php

namespace App\DTOs;

class AbstractDTO
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
