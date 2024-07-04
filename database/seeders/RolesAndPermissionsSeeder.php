<?php

namespace Database\Seeders;

use App\Models\SystemStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for each model
        $models = [
            'AccountFunding', 'City', 'Country', 'Fiat', 'GeneralSetting',
            'ProductRating', 'ServiceType', 'State', 'StoreTheme',
            'SystemStaff', 'Team', 'Testimonial', 'Transaction', 'User',
            'UserActivity', 'UserAd', 'UserAdPhoto', 'UserBalance',
            'UserBank', 'UserDeposit', 'UserDevice', 'UserNotification',
            'UserSetting', 'UserStore', 'UserStoreCatalogCategory',
            'UserStoreCoupon', 'UserStoreCustomer', 'UserStoreInvoice',
            'UserStoreNewsletter', 'UserStoreOrder', 'UserStoreOrderBreakdown',
            'UserStoreProduct', 'UserStoreProductColorVariant',
            'UserStoreProductSizeVariant', 'UserStoreProductImage',
            'UserStoreSetting', 'UserStoreSubscriber'
        ];

        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$action} {$model}",'guard_name' => 'staff']);
            }
        }

        // Specific update permissions
        Permission::create(['name' => 'update SuperAdmin','guard_name' => 'staff']);
        Permission::create(['name' => 'update Admin','guard_name' => 'staff']);

        // Create roles and assign created permissions

         // Superadmin role
        $superadmin = Role::create(['name' => 'superadmin','guard_name' => 'staff']);
        $superadmin->givePermissionTo(Permission::all());

        // Admin role
        $admin = Role::create(['name' => 'admin','guard_name' => 'staff']);
        $admin->givePermissionTo(Permission::all());
        // Remove permission to update superadmin
        $admin->revokePermissionTo('update SuperAdmin');

         // Customer Support role
         $customerSupport = Role::create(['name' => 'customer-support','guard_name' => 'staff']);
         $customerSupport->givePermissionTo([
             'read AccountFunding',
             'read City',
             'read Country',
             'read Fiat',
             'read GeneralSetting',
             'read ProductRating',
             'read ServiceType',
             'read State',
             'read StoreTheme',
             'read SystemStaff',
             'read Team',
             'read Testimonial',
             'read Transaction',
             'read User', 'update User',
             'read UserActivity',
             'read UserAd', 'delete UserAd',
             'read UserAdPhoto', 'delete UserAdPhoto',
             'read UserBalance',
             'read UserBank',
             'read UserDeposit',
             'read UserDevice',
             'read UserNotification', 'delete UserNotification',
             'read UserSetting',
             'read UserStore', 'update UserStore',
             'read UserStoreCatalogCategory',
             'read UserStoreCoupon', 'delete UserStoreCoupon',
             'read UserStoreCustomer',
             'read UserStoreInvoice',
             'read UserStoreNewsletter',
             'read UserStoreOrder', 'update UserStoreOrder',
             'read UserStoreOrderBreakdown', 'update UserStoreOrderBreakdown',
             'read UserStoreProduct', 'update UserStoreProduct',
             'read UserStoreProductColorVariant',
             'read UserStoreProductSizeVariant',
             'read UserStoreProductImage',
             'read UserStoreSetting',
             'read UserStoreSubscriber',
         ]);

        // Technical Unit role
        $technicalUnit = Role::create(['name' => 'technical-unit','guard_name' => 'staff']);
        foreach ($models as $model) {
            $technicalUnit->givePermissionTo([
                "read {$model}",
                "update {$model}",
                "delete {$model}"
            ]);
        }
        // Remove permissions to update superadmin and admin
        $technicalUnit->revokePermissionTo('update SuperAdmin');
        $technicalUnit->revokePermissionTo('update Admin');
        $technicalUnit->revokePermissionTo('update UserBalance');

        // Accountant role
        $accountant = Role::create(['name' => 'accountant','guard_name' => 'staff']);
        $accountant->givePermissionTo([
            'create UserBalance', 'read UserBalance', 'update UserBalance',
            'create Transaction', 'read Transaction', 'update Transaction', 'delete Transaction',
            'read UserStoreOrder', 'update UserStoreOrder',
        ]);

         // Create a superadmin staff member
         $superAdminStaff = SystemStaff::create([
            'name' => 'Michael Erastus',
            'email' => 'meritinfos@gmail.com',
            'password' => Hash::make('47298815Me!'),
            'role' => 'superadmin',
        ]);

        // Assign the superadmin role to the staff member
        $superAdminStaff->assignRole($superadmin);
    }
}
