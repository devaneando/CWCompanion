<?php

declare (strict_types = 1);

namespace App\Controller\CRUD;

use Sonata\AdminBundle\Controller\CRUDController;
use App\Traits\LoggedUserTrait;
use App\Traits\Services\LoggerTrait;

final class UserController extends CRUDController
{
    use LoggedUserTrait;
    use LoggerTrait;
}
