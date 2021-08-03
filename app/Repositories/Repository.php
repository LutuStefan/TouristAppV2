<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class Repository implements RepositoryInterface
{

    public function currentUser()
    {
        return DB::table('users')
            ->where('id', Auth()->user()->id)
            ->first();
    }

    public function getUserById($userId)
    {
        return DB::table('users')
            ->where('id', $userId)
            ->first();
    }

    public function updateUserData($newUserData)
    {
        if((int) $newUserData['userId'] !== Auth()->user()->id) {
            return 'error';
        }

        try {
            $querry = DB::table('users')
                ->where('id', $newUserData['userId']);

            if (!empty($newUserData['userName'])) {
                $querry->update(['name' => $newUserData['userName']]);
            }

            if (!empty($newUserData['userEmail'])) {
                $querry->update(['email' => $newUserData['userEmail']]);
            }

            if (!empty($newUserData['userPhone'])) {
                $querry->update(['phone' => $newUserData['userPhone']]);
            }
            return 'success';
        } catch (\Exception $e) {
            return 'error';
        }
    }

    public function getUserHotels($userId)
    {
        $querry = DB::table('hotels')
            ->where('h_admin', $userId)
            ->get();
        return $querry;
    }


}
