<?php

namespace App;

use Laravel\Sanctum\PersonalAccessToken;

class Token extends PersonalAccessToken
{
    protected $table = 'personal_access_tokens';

    public function login()
    {
        return $this->hasOne(Login::class);
    }

    public function delete()
    {
    	$this->login()->delete();
    	return parent::delete();
    }
}
