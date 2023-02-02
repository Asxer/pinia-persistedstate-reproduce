<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mails\ForgotPasswordMail;
use App\Models\Role;
use Illuminate\Support\Arr;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Artel\Support\Services\EntityService;
use Illuminate\Support\Facades\Mail;

/**
 * @property UserRepository $repository
 */
class UserService extends EntityService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->setRepository(UserRepository::class);
    }

    public function search($filters)
    {
        return $this->repository
            ->searchQuery($filters)
            ->filterBy('role_id')
            ->filterByQuery(['name', 'email'])
            ->getSearchResults();
    }
}
