<?php
/**
 * Created by PhpStorm.
 * User: mohammedsobhei
 * Date: 2/25/19
 * Time: 7:43 PM
 */


namespace App\Resolvers;

use App\Models\Country;
use App\Models\LinkedSocialAccount;
use App\Models\User;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountsService
{
    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param string $provider
     * @param ProviderUser $providerUser
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {

        $linkedSocialAccount = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {

            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
                if (isset($user)) goto COMPLETE;

            }



            $user = new User();
            $user->name = $providerUser->getName();
            $user->email = $providerUser->getEmail();

            $user->save();

        }

        COMPLETE:

        $user->linkedSocialAccounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);
        return $user;
    }
}
