<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class FriendService extends BasicService
{
    const STATUS_NOT_FRIENDS = 0;
    const STATUS_IN_SUBSCRIBERS = 1;
    const STATUS_REQUEST_SENT = 2;
    const STATUS_FRIENDS = 3;

    public function getStatus(int $user_id, int $friend_id): int
    {
        $friendRecord = DB::select("SELECT user_id, friend_id FROM friends WHERE (user_id = $user_id AND friend_id = $friend_id) OR (user_id = $friend_id AND friend_id = $user_id)");

        if (count($friendRecord) == 0) {
            return self::STATUS_NOT_FRIENDS;
        } else if (count($friendRecord) == 1) {
            if ($this->getFirst($friendRecord)->user_id == $user_id) {
                //current user sent request to friend,
                return self::STATUS_REQUEST_SENT;
            }

            return self::STATUS_IN_SUBSCRIBERS;
        } else if (count($friendRecord) == 2) {
            return self::STATUS_FRIENDS;
        } else {
            //record count > 2, this is not allowed, need delete friends records
            $this->deleteFriendRecords($user_id, $friend_id);
        }

        return self::STATUS_NOT_FRIENDS;
    }

    public function add(int $user_id, int $friend_id)
    {
        $friendsRecordsCount = $this->getFriendsRecordsCount($user_id, $friend_id);

        if($friendsRecordsCount < 2) {
            DB::insert(
                'INSERT INTO friends (user_id, friend_id) VALUES (?, ?)',
                [
                    $user_id,
                    $friend_id
                ]
            );
        }

        if($friendsRecordsCount == 1) {
            $this->setFriendStatus($user_id, $friend_id, 1);
        }
        //if records > 1, not creating a record
    }

    public function remove(mixed $user_id, int $friend_id)
    {
        DB::delete("DELETE FROM friends WHERE user_id = ? and friend_id = ?",
            [
                $user_id,
                $friend_id
            ]
        );
        $this->setFriendStatus($user_id, $friend_id, 0);
    }

    public function getFriends($userId): array
    {
        return DB::select(
            "SELECT u.id, u.name, u.surname, u.age, u.interests, u.city FROM friends LEFT JOIN users u on u.id=friend_id WHERE user_id = $userId and status = true"
        );
    }

    private function deleteFriendRecords(int $userId, int $friendId)
    {
        DB::delete("DELETE FROM friends WHERE (user_id = $userId AND friend_id = $friendId) OR (user_id = $friendId and friend_id = $userId)");
    }

    private function getFriendsRecordsCount(int $userId, int $friendId): int
    {
        return $this->getCountValue(DB::select("SELECT COUNT(*) FROM friends WHERE (user_id = $userId and friend_id = $friendId) OR (user_id = $friendId and friend_id = $userId)"));
    }

    private function setFriendStatus(int $user_id, int $friend_id, int $status)
    {
        DB::update("UPDATE friends set status = $status WHERE (user_id = $user_id and friend_id = $friend_id) OR (user_id = $friend_id and friend_id = $user_id)");
    }
}
