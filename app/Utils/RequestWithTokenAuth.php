<?php

namespace App\Utils;

use App\Models\User;
use Illuminate\Http\Request;

class RequestWithTokenAuth extends Request
{
    public ?User $user = null;

    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
