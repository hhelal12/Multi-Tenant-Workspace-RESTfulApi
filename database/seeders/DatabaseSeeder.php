<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@test.com',
            'password' => 'password123',
            'role' => 'member',
        ]);

        $user3 = User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@test.com',
            'password' => 'password123',
            'role' => 'member',
        ]);

        // Create Workspaces
        $workspace1 = Workspace::create([
            'name' => 'Marketing Team',
            'description' => 'Marketing department workspace',
            'leader_id' => $user1->id,
        ]);

        $workspace2 = Workspace::create([
            'name' => 'Development Team',
            'description' => 'Dev department workspace',
            'leader_id' => $user2->id,
        ]);

        // Add Users to Workspaces
        $workspace1->users()->attach([$user2->id, $user3->id]);
        $workspace2->users()->attach([$user1->id, $user3->id]);

        // Create Tasks
        Task::create([
            'title' => 'Create marketing plan',
            'body' => 'Develop Q1 marketing strategy',
            'workspace_id' => $workspace1->id,
            'creator_id' => $user1->id,
            'assigned_to_id' => $user2->id,
            'status' => 'pending',
            'deadline' => '2025-03-01',
        ]);

        Task::create([
            'title' => 'Design logo',
            'body' => 'Create new company logo',
            'workspace_id' => $workspace1->id,
            'creator_id' => $user1->id,
            'assigned_to_id' => $user3->id,
            'status' => 'in_progress',
            'deadline' => '2025-02-15',
        ]);

        Task::create([
            'title' => 'Build API',
            'body' => 'Create REST API',
            'workspace_id' => $workspace2->id,
            'creator_id' => $user2->id,
            'assigned_to_id' => $user1->id,
            'status' => 'completed',
            'deadline' => '2025-02-01',
        ]);

        Task::create([
            'title' => 'Write documentation',
            'body' => 'Document all endpoints',
            'workspace_id' => $workspace2->id,
            'creator_id' => $user2->id,
            'status' => 'pending',
        ]);
    }
}