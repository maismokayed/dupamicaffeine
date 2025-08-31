<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
       
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission->value,
                'guard_name' => 'web'
            ]);
        }

        
        foreach (RoleEnum::cases() as $role) {
            Role::firstOrCreate([
                'name' => $role->value,
                'guard_name' => 'web'
            ]);
        }

        
        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        $adminRole->syncPermissions(Permission::all());

    
        $customerRole = Role::where('name', RoleEnum::CUSTOMER->value)->first();
        $customerPermissions = [
            PermissionEnum::VIEW_PRODUCTS->value,
            PermissionEnum::VIEW_CATEGORIES->value,
            PermissionEnum::ADD_TO_CART->value,
            PermissionEnum::UPDATE_CART->value,
            PermissionEnum::REMOVE_FROM_CART->value,
            PermissionEnum::CHECKOUT->value,
            PermissionEnum::VIEW_OWN_ORDERS->value,
            PermissionEnum::APPLY_COUPON->value,
            PermissionEnum::WRITE_REVIEW->value,
            PermissionEnum::EDIT_OWN_REVIEW->value,
            PermissionEnum::DELETE_OWN_REVIEW->value,
            PermissionEnum::ADD_TO_WISHLIST->value,
            PermissionEnum::REMOVE_FROM_WISHLIST->value,
            PermissionEnum::VIEW_OWN_WISHLIST->value,
            PermissionEnum::VIEW_OWN_PROFILE->value,
            PermissionEnum::UPDATE_OWN_PROFILE->value
        ];
        $customerRole->syncPermissions($customerPermissions);
    }
}