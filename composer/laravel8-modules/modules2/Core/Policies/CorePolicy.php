<?php

namespace Modules\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CorePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
