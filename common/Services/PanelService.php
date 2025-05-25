<?php

namespace Common\Services;

class PanelService
{
    const SUPER_ADMIN_PANEL = 'super-admin';
    const ADMIN_PANLE = 'admin';
    const MANAGER_PANEL = 'manager';
    const USER_PANEL = 'user';

    const panels = [
        self::SUPER_ADMIN_PANEL,
        self::ADMIN_PANLE,
        self::MANAGER_PANEL,
        self::USER_PANEL,
    ];

}
