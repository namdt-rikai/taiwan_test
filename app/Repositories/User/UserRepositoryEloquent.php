<?php

namespace App\Repositories\User;

use App\Repositories\Base\RepositoryEloquent;

class UserRepositoryEloquent extends RepositoryEloquent implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function handleFilter($select, $keyword = null, $typeId = null, $statusId = null, $userId = null)
    {
        return $this->makeSimpleQuery(
            $select
        )->when(
            $keyword != null,
            function ($query) use ($keyword) {
                $query->where(
                    function ($q) use ($keyword) {
                        return $q->where('name', 'like', "%{$keyword}%")->orWhere('username', 'like', "%{$keyword}%")->orWhere('phone', 'like', "%{$keyword}%");
                    }
                );
            }
        )->when(
            $typeId != null,
            function ($query) use ($typeId) {
                return $query->whereTypeId($typeId);
            }
        )->when(
            $statusId != null,
            function ($query) use ($statusId) {
                return $query->whereStatusId($statusId);;
            }
        )->when(
            $userId != null,
            function ($query) use ($userId) {
                return $query->whereId($userId);
            }
        );
    }

    public function getCountSurvey($user)
    {
        return $user->surveys()->count();
    }
}
