<?php

namespace App\Rules;

use App\Models\RestoreAccountRequest;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ValidateDeletedEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $restoreRequest;
    public function __construct()
    {
        //

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $email = $value;
        $user = User::withTrashed()->where('email', $email)->first();
        if(!$user){
            return true;
        }
        if ($user && $user->trashed()) {
            $this->restoreRequest = RestoreAccountRequest::where(['email' => $email, 'status' => 'pending'])->first();
        }
        if($user && !$user->trashed()){
            return true;
        }


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->restoreRequest){
            $message =  __('messages.Your account is deactivated. A request to restore your account has been made. Please wait for the admin to respond.');
        }
        $message = __('messages.This account has been deleted. If you want to restore it, kindly submit a request.');
        return $message;
    }
}
