<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Collaboration;
use App\Models\Ecosystem;
use App\Models\Event;
use App\Models\CollectiveAction;
use App\Models\Connection;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use App\Models\EventCategory;
use App\Models\SystemSetting;
use App\Rules\UniqueEmailForActiveUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware is applied at route level in web.php
    }

    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'profiles' => Profile::count(),
            'ecosystems' => Ecosystem::count(),
            'collective_actions' => CollectiveAction::count(),
            'connections' => Connection::count(),
            'interests' => Interest::count(),
            'skills' => Skill::count(),
            'contributions' => Contribution::count(),
            'event_categories' => EventCategory::count(),
            'ecosystem_builders_pending' => User::where('is_ecosystem_builder', true)->where('ecosystem_builder_status', 'pending')->count(),
            'ecosystem_builders_approved' => User::where('is_ecosystem_builder', true)->where('ecosystem_builder_status', 'approved')->count(),
            'ecosystem_builders_rejected' => User::where('is_ecosystem_builder', true)->where('ecosystem_builder_status', 'rejected')->count(),
        ];

        $recentUsers = User::with('profile')->latest()->take(5)->get();
        $recentEcosystems = Ecosystem::with('creator')->latest()->take(5)->get();
        $recentCollectiveActions = CollectiveAction::with('creator')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentEcosystems', 'recentCollectiveActions'));
    }

    /**
     * Display users management page
     */
    public function users(Request $request)
    {
        $query = User::with('profile');

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $users = $query->paginate(15)->appends($request->query());
        $superAdminCount = User::where('role', 'super_admin')->count();

        return view('admin.users.index', compact('users', 'superAdminCount'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        // Check if user is soft deleted (if User model uses SoftDeletes)
        if (method_exists($user, 'trashed') && $user->trashed()) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
        
        $user->load(['profile', 'sentConnections', 'receivedConnections', 'collaborations', 'events']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Edit user form
     */
    public function editUser(User $user)
    {
        // Check if user is soft deleted (if User model uses SoftDeletes)
        if (method_exists($user, 'trashed') && $user->trashed()) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        // Check if user is soft deleted (if User model uses SoftDeletes)
        if (method_exists($user, 'trashed') && $user->trashed()) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', new UniqueEmailForActiveUsers($user->id)],
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Check if user is soft deleted (if User model uses SoftDeletes)
        if (method_exists($user, 'trashed') && $user->trashed()) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
        
        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last super admin.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Display ecosystems management page
     */
    public function ecosystems(Request $request)
    {
        $query = Ecosystem::with('creator');

        if ($request->has('search') && $request->search) {
            $query->where('ecosystem_title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $ecosystems = $query->paginate(15)->appends($request->query());

        return view('admin.ecosystems.index', compact('ecosystems'));
    }

    /**
     * Show ecosystem details
     */
    public function showEcosystem(Ecosystem $ecosystem)
    {
        $ecosystem->load(['creator', 'users']);
        return view('admin.ecosystems.show', compact('ecosystem'));
    }

    /**
     * Delete ecosystem
     */
    public function deleteEcosystem(Ecosystem $ecosystem)
    {
        $ecosystem->delete();
        return redirect()->route('admin.ecosystems')->with('success', 'Ecosystem deleted successfully.');
    }

    /**
     * Display collective actions management page
     */
    public function collectiveActions(Request $request)
    {
        $query = CollectiveAction::with('creator');

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $collectiveActions = $query->paginate(15)->appends($request->query());

        return view('admin.collective-actions.index', compact('collectiveActions'));
    }

    /**
     * Show collective action details
     */
    public function showCollectiveAction(CollectiveAction $collectiveAction)
    {
        $collectiveAction->load(['creator', 'contributors', 'participatingEcosystems']);
        return view('admin.collective-actions.show', compact('collectiveAction'));
    }

    /**
     * Delete collective action
     */
    public function deleteCollectiveAction(CollectiveAction $collectiveAction)
    {
        $collectiveAction->delete();
        return redirect()->route('admin.collective-actions')->with('success', 'Collective action deleted successfully.');
    }

    /**
     * Display connections management page
     */
    public function connections(Request $request)
    {
        $query = Connection::with(['requester', 'receiver']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $connections = $query->paginate(15)->appends($request->query());

        return view('admin.connections.index', compact('connections'));
    }

    /**
     * Show connection details
     */
    public function showConnection(Connection $connection)
    {
        // Check if connection is soft deleted (if Connection model uses SoftDeletes)
        if (method_exists($connection, 'trashed') && $connection->trashed()) {
            return redirect()->route('admin.connections')->with('error', 'Connection not found.');
        }
        
        $connection->load(['requester', 'receiver']);
        return view('admin.connections.show', compact('connection'));
    }

    /**
     * Delete connection
     */
    public function deleteConnection(Connection $connection)
    {
        // Check if connection is soft deleted (if Connection model uses SoftDeletes)
        if (method_exists($connection, 'trashed') && $connection->trashed()) {
            return redirect()->route('admin.connections')->with('error', 'Connection not found.');
        }
        
        $connection->delete();
        return redirect()->route('admin.connections')->with('success', 'Connection deleted successfully.');
    }

    /**
     * Display interests management page
     */
    public function interests(Request $request)
    {
        $query = Interest::withCount('profiles');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Status filter based on usage
        if ($request->has('status') && $request->status) {
            if ($request->status === 'used') {
                $query->having('profiles_count', '>', 0);
            } elseif ($request->status === 'unused') {
                $query->having('profiles_count', '=', 0);
            }
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $interests = $query->paginate(15)->appends($request->query());
        return view('admin.interests.index', compact('interests'));
    }

    /**
     * Create interest
     */
    public function createInterest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:interests',
        ]);

        Interest::create($request->only('name'));

        return redirect()->route('admin.interests')->with('success', 'Interest created successfully.');
    }

    /**
     * Update interest
     */
    public function updateInterest(Request $request, Interest $interest)
    {
        // Check if interest is soft deleted (if Interest model uses SoftDeletes)
        if (method_exists($interest, 'trashed') && $interest->trashed()) {
            return redirect()->route('admin.interests')->with('error', 'Interest not found.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('interests')->ignore($interest->id)],
        ]);

        $interest->update($request->only('name'));

        return redirect()->route('admin.interests')->with('success', 'Interest updated successfully.');
    }

    /**
     * Delete interest
     */
    public function deleteInterest(Interest $interest)
    {
        // Check if interest is soft deleted (if Interest model uses SoftDeletes)
        if (method_exists($interest, 'trashed') && $interest->trashed()) {
            return redirect()->route('admin.interests')->with('error', 'Interest not found.');
        }
        
        $interest->delete();
        return redirect()->route('admin.interests')->with('success', 'Interest deleted successfully.');
    }

    /**
     * Display skills management page
     */
    public function skills(Request $request)
    {
        $query = Skill::withCount('profiles');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Status filter based on usage
        if ($request->has('status') && $request->status) {
            if ($request->status === 'used') {
                $query->having('profiles_count', '>', 0);
            } elseif ($request->status === 'unused') {
                $query->having('profiles_count', '=', 0);
            }
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $skills = $query->paginate(15)->appends($request->query());
        return view('admin.skills.index', compact('skills'));
    }

    /**
     * Create skill
     */
    public function createSkill(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills',
        ]);

        Skill::create($request->only('name'));

        return redirect()->route('admin.skills')->with('success', 'Skill created successfully.');
    }

    /**
     * Update skill
     */
    public function updateSkill(Request $request, Skill $skill)
    {
        // Check if skill is soft deleted (if Skill model uses SoftDeletes)
        if (method_exists($skill, 'trashed') && $skill->trashed()) {
            return redirect()->route('admin.skills')->with('error', 'Skill not found.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('skills')->ignore($skill->id)],
        ]);

        $skill->update($request->only('name'));

        return redirect()->route('admin.skills')->with('success', 'Skill updated successfully.');
    }

    /**
     * Delete skill
     */
    public function deleteSkill(Skill $skill)
    {
        // Check if skill is soft deleted (if Skill model uses SoftDeletes)
        if (method_exists($skill, 'trashed') && $skill->trashed()) {
            return redirect()->route('admin.skills')->with('error', 'Skill not found.');
        }
        
        $skill->delete();
        return redirect()->route('admin.skills')->with('success', 'Skill deleted successfully.');
    }

    /**
     * Display contributions management page
     */
    public function contributions(Request $request)
    {
        $query = Contribution::withCount('profiles');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Status filter based on usage
        if ($request->has('status') && $request->status) {
            if ($request->status === 'used') {
                $query->having('profiles_count', '>', 0);
            } elseif ($request->status === 'unused') {
                $query->having('profiles_count', '=', 0);
            }
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $contributions = $query->paginate(15)->appends($request->query());

        return view('admin.contributions.index', compact('contributions'));
    }

    /**
     * Create contribution
     */
    public function createContribution(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contributions',
        ]);

        Contribution::create($request->only('name'));

        return redirect()->route('admin.contributions')->with('success', 'Contribution created successfully.');
    }

    /**
     * Update contribution
     */
    public function updateContribution(Request $request, Contribution $contribution)
    {
        // Check if contribution is soft deleted (if Contribution model uses SoftDeletes)
        if (method_exists($contribution, 'trashed') && $contribution->trashed()) {
            return redirect()->route('admin.contributions')->with('error', 'Contribution not found.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('contributions')->ignore($contribution->id)],
        ]);

        $contribution->update($request->only('name'));

        return redirect()->route('admin.contributions')->with('success', 'Contribution updated successfully.');
    }

    /**
     * Delete contribution
     */
    public function deleteContribution(Contribution $contribution)
    {
        // Check if contribution is soft deleted (if Contribution model uses SoftDeletes)
        if (method_exists($contribution, 'trashed') && $contribution->trashed()) {
            return redirect()->route('admin.contributions')->with('error', 'Contribution not found.');
        }
        
        $contribution->delete();
        return redirect()->route('admin.contributions')->with('success', 'Contribution deleted successfully.');
    }

    /**
     * Display event categories management page
     */
    public function eventCategories(Request $request)
    {
        $query = EventCategory::withCount('events');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Status filter based on usage
        if ($request->has('status') && $request->status) {
            if ($request->status === 'used') {
                $query->having('events_count', '>', 0);
            } elseif ($request->status === 'unused') {
                $query->having('events_count', '=', 0);
            }
        }

        // Time-based filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by creation date (newest first by default)
        $query->orderBy('created_at', 'desc');

        $categories = $query->paginate(15)->appends($request->query());
        return view('admin.event-categories.index', compact('categories'));
    }

    /**
     * Create event category
     */
    public function createEventCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:event_categories',
        ]);

        EventCategory::create($request->only('name'));

        return redirect()->route('admin.event-categories')->with('success', 'Event category created successfully.');
    }

    /**
     * Update event category
     */
    public function updateEventCategory(Request $request, EventCategory $eventCategory)
    {
        // Check if event category is soft deleted (if EventCategory model uses SoftDeletes)
        if (method_exists($eventCategory, 'trashed') && $eventCategory->trashed()) {
            return redirect()->route('admin.event-categories')->with('error', 'Event category not found.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('event_categories')->ignore($eventCategory->id)],
        ]);

        $eventCategory->update($request->only('name'));

        return redirect()->route('admin.event-categories')->with('success', 'Event category updated successfully.');
    }

    /**
     * Delete event category
     */
    public function deleteEventCategory(EventCategory $eventCategory)
    {
        // Check if event category is soft deleted (if EventCategory model uses SoftDeletes)
        if (method_exists($eventCategory, 'trashed') && $eventCategory->trashed()) {
            return redirect()->route('admin.event-categories')->with('error', 'Event category not found.');
        }
        
        $eventCategory->delete();
        return redirect()->route('admin.event-categories')->with('success', 'Event category deleted successfully.');
    }

    /**
     * Display system settings management page
     */
    public function systemSettings()
    {
        $settings = SystemSetting::all()->keyBy('key');
        return view('admin.system-settings.index', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSystemSettings(Request $request)
    {
        // Checkbox yang tidak dicentang tidak akan dikirim dalam request
        // Jadi kita perlu menangani ini dengan benar
        $loginEnabled = $request->has('login_enabled') ? '1' : '0';
        $maintenanceMode = $request->has('maintenance_mode') ? '1' : '0';
        $registrationEnabled = $request->has('registration_enabled') ? '1' : '0';
        $connectionsEnabled = $request->has('connections_enabled') ? '1' : '0';
        $collaborationsEnabled = $request->has('collaborations_enabled') ? '1' : '0';
        $userActionsEnabled = $request->has('user_actions_enabled') ? '1' : '0';

        SystemSetting::setValue('login_enabled', $loginEnabled);
        SystemSetting::setValue('maintenance_mode', $maintenanceMode);
        SystemSetting::setValue('registration_enabled', $registrationEnabled);
        SystemSetting::setValue('connections_enabled', $connectionsEnabled);
        SystemSetting::setValue('collaborations_enabled', $collaborationsEnabled);
        SystemSetting::setValue('user_actions_enabled', $userActionsEnabled);

        return redirect()->route('admin.system-settings')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}