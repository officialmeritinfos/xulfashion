<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class SystemStaff extends Authenticatable
{
    use HasFactory,Notifiable, HasRoles;
    protected $guarded=[];

    protected $guard_name = 'staff';

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id'; // Assuming your primary key is 'id'
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password; // Assuming your password field is named 'password'
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        return $this->remember_token; // Assuming your remember_token field name
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string|null  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Assuming your remember_token field name
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token'; // Assuming your remember_token field name
    }
}
