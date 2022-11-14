<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function handleFilter($select, $keyword = null, $typeId = null, $statusId = null, $userId = null);

    public function getCountSurvey($user);
}

?>
