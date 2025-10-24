<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AssignUserRoles extends Command
{
    protected $signature = 'users:assign-roles';
    protected $description = 'Assign default roles to existing users based on their role field';

    public function handle()
    {
        $this->info('Assigning roles to existing users...');

        $roleMappings = [
            'super_admin' => 'super_admin',
            'admin' => 'administrator', // Map admin to administrator
            'administrator' => 'administrator',
            'clinical_supervisor' => 'clinical_supervisor',
            'caregiver' => 'caregiver',
            'registered_nurse' => 'clinical_supervisor', // Map nurses to clinical supervisor
            'nurse' => 'clinical_supervisor',
            'family_member' => 'family_member',
        ];

        $users = User::all();
        $assignedCount = 0;

        foreach ($users as $user) {
            $userRole = $user->role;
            
            if (isset($roleMappings[$userRole])) {
                $roleName = $roleMappings[$userRole];
                $role = Role::where('name', $roleName)->first();
                
                if ($role) {
                    $user->assignRole($roleName);
                    $this->line("Assigned role '{$roleName}' to {$user->first_name} {$user->last_name} ({$user->email})");
                    $assignedCount++;
                } else {
                    $this->warn("Role '{$roleName}' not found for user {$user->email}");
                }
            } else {
                // Default to caregiver role for unknown roles
                $user->assignRole('caregiver');
                $this->line("Assigned default role 'caregiver' to {$user->first_name} {$user->last_name} ({$user->email})");
                $assignedCount++;
            }
        }

        $this->info("✅ Successfully assigned roles to {$assignedCount} users!");
        
        // Show summary
        $this->line('');
        $this->line('📋 Role Assignment Summary:');
        foreach (Role::all() as $role) {
            $count = User::whereHas('roles', function($query) use ($role) {
                $query->where('name', $role->name);
            })->count();
            $this->line("  • {$role->name}: {$count} users");
        }
    }
}