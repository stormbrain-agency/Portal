<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Dashboard > W-9
Breadcrumbs::for('county-provider-w9.upload', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('W-9 List', route('c'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Management', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Users', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('user-management.permissions.index'));
});

// ---------------------------------------------
// Home > Dashboard > County Provider Payment Resports
Breadcrumbs::for('county-provider-payment-report.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('County Provider Payment Resports', route('county-provider-payment-report.index'));
});


// ---------------------------------------------
// Home > Dashboard > County Provider W9
// Breadcrumbs::for('county-provider-w9.index', function (BreadcrumbTrail $trail) {
//     $trail->parent('dashboard');
//     $trail->push('County Provider W-9', route('dashboard-provider-w9.index'));
// });

// ---------------------------------------------
// Home > Dashboard > County mRec/aRec Submissions
Breadcrumbs::for('county-mrac-arac.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('County mRec/aRec Submissions', route('county-mrac-arac.index'));
});

// ---------------------------------------------
// Home > Dashboard > Notification Management
Breadcrumbs::for('notification-management.dashboard.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Notification Management', route('notification-management.dashboard.index'));
});
Breadcrumbs::for('notification-management.email.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Notification Email Management', route('notification-management.email.index'));
});

// ---------------------------------------------
// Home > Dashboard > Activity Management
Breadcrumbs::for('activity-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Activity Management', route('activity-management.index'));
});
