<?php

use App\Enum\UserGroup;

return [
    UserGroup::SUBSCRIBER => 'subscriber user',
    UserGroup::ADMIN => 'admin user',
    UserGroup::AGENT => 'agent user',
    UserGroup::SUPER_AGENT => 'super-agent user',
    UserGroup::MERCHANT => 'merchant user',
    UserGroup::DISTRIBUTOR => 'distributor user',
    '' => []
    ];
