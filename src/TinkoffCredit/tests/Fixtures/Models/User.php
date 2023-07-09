<?php

namespace Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/**
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 */
class User extends Model
{
    protected function getFirstNameAttribute(): string
    {
        return TestCase::USER_FIRST_NAME;
    }

    protected function getMiddleNameAttribute(): string
    {
        return TestCase::USER_MIDDLE_NAME;
    }

    protected function getLastNameAttribute(): string
    {
        return TestCase::USER_LAST_NAME;
    }

    protected function getPhoneAttribute(): string
    {
        return TestCase::USER_PHONE;
    }

    protected function getEmailAttribute(): string
    {
        return TestCase::USER_EMAIL;
    }
}
