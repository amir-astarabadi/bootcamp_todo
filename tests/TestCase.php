<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected ?User $authUser = null;

    protected function login(?User $user = null)
    {
        $this->authUser = $user ? $user : User::factory()->create();
        Auth::login($this->authUser);
    }
}
