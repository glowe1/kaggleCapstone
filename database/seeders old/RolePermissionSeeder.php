<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define role permissions
        $rolePermissions = [
            'super_admin' => [
                // Full access to everything
                'all'
            ],
            'administrator' => [
                // Admin access (no system management)
                'view_admin_panel',
                'view_dashboard',
                'view_users', 'create_users', 'edit_users', 'delete_users', 'assign_roles_users',
                'view_own_profile', 'edit_own_profile',
                'view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_permissions_roles',
                'view_residents', 'create_residents', 'edit_residents', 'delete_residents',
                'view_resident_medications', 'manage_resident_medications',
                'view_resident_documents', 'upload_resident_documents',
                'view_medications', 'create_medications', 'edit_medications', 'delete_medications',
                'view_leave_requests', 'create_leave_requests', 'edit_leave_requests', 'delete_leave_requests', 'approve_leave_requests',
                'view_assignments', 'create_assignments', 'edit_assignments', 'delete_assignments',
                'view_resident_manager',
                'view_facilities', 'create_facilities', 'edit_facilities', 'delete_facilities',
                'view_branches', 'create_branches', 'edit_branches', 'delete_branches',
                'view_reports', 'export_reports', 'view_staff_reports', 'view_resident_reports', 'view_medication_reports', 'view_leave_reports',
                'view_appointments', 'create_appointments', 'edit_appointments', 'delete_appointments',
                'view_vital_signs', 'create_vital_signs', 'edit_vital_signs', 'delete_vital_signs',
                'view_vital_ranges', 'create_vital_ranges', 'edit_vital_ranges', 'delete_vital_ranges',
                'view_notifications', 'manage_notifications', 'send_notifications',
            ],
            'clinical_supervisor' => [
                // Clinical management access
                'view_admin_panel',
                'view_dashboard',
                'view_own_profile', 'edit_own_profile',
                'view_residents', 'create_residents', 'edit_residents',
                'view_resident_medications', 'manage_resident_medications',
                'view_resident_documents', 'upload_resident_documents',
                'view_medications', 'create_medications', 'edit_medications',
                'administer_medications', 'view_medication_history',
                'view_leave_requests', 'create_leave_requests', 'edit_leave_requests', 'approve_leave_requests',
                'view_assignments', 'create_assignments', 'edit_assignments',
                'view_resident_manager',
                'view_branches', 'edit_branches',
                'view_appointments', 'create_appointments', 'edit_appointments',
                'view_vital_signs', 'create_vital_signs', 'edit_vital_signs',
                'view_vital_ranges', 'create_vital_ranges', 'edit_vital_ranges',
                'view_reports', 'view_staff_reports', 'view_resident_reports', 'view_medication_reports',
                'view_notifications', 'manage_notifications', 'send_notifications',
            ],
            'caregiver' => [
                // Limited caregiving access - NO facility/branch/user/resident management
                'view_admin_panel',
                'view_dashboard',
                'view_own_profile', 'edit_own_profile',
                'view_resident_medications', 'manage_resident_medications',
                'view_resident_documents',
                'view_medications',
                'administer_medications', 'view_medication_history',
                'view_leave_requests', 'create_leave_requests', 'edit_own_leave_requests',
                'view_assignments',
                'view_appointments', 'create_appointments',
                'view_vital_signs', 'create_vital_signs',
                'view_notifications',
            ],
            'family_member' => [
                // Very limited access
                'view_own_profile', 'edit_own_profile',
                'view_residents',
                'view_resident_medications',
                'view_notifications',
            ]
        ];

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = Role::where('name', $roleName)->first();
            
            if (!$role) {
                $role = Role::create([
                    'name' => $roleName,
                    'guard_name' => 'web'
                ]);
                $this->command->info("Created role: {$roleName}");
            }

            // Clear existing permissions
            $role->permissions()->detach();

            if (in_array('all', $permissionNames)) {
                // Super admin gets all permissions
                $allPermissions = Permission::all();
                foreach ($allPermissions as $permission) {
                    $role->givePermissionTo($permission);
                }
                $this->command->info("Assigned ALL permissions to {$roleName}");
            } else {
                // Assign specific permissions
                foreach ($permissionNames as $permissionName) {
                    $permission = Permission::where('name', $permissionName)->first();
                    if ($permission) {
                        $role->givePermissionTo($permission);
                    } else {
                        $this->command->warn("Permission not found: {$permissionName}");
                    }
                }
                $this->command->info("Assigned " . count($permissionNames) . " permissions to {$roleName}");
            }
        }

        $this->command->info('Role permissions setup completed!');
        
        // Show summary
        $this->command->line('');
        $this->command->line('📋 Permission Summary:');
        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = Role::where('name', $roleName)->first();
            $count = $role->permissions()->count();
            $this->command->line("  • {$roleName}: {$count} permissions");
        }
    }
}
