<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Collaboration;
use App\Models\Event;
use App\Models\Connection;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use App\Models\EventCategory;
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
            'collaborations' => Collaboration::count(),
            'events' => Event::count(),
            'connections' => Connection::count(),
            'interests' => Interest::count(),
            'skills' => Skill::count(),
            'contributions' => Contribution::count(),
            'event_categories' => EventCategory::count(),
        ];

        $recentUsers = User::with('profile')->latest()->take(5)->get();
        $recentCollaborations = Collaboration::with('creator')->latest()->take(5)->get();
        $recentEvents = Event::with('creator')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentCollaborations', 'recentEvents'));
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

        $users = $query->paginate(15);
        $superAdminCount = User::where('role', 'super_admin')->count();

        return view('admin.users.index', compact('users', 'superAdminCount'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        $user->load(['profile', 'sentConnections', 'receivedConnections', 'collaborations', 'events']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Edit user form
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
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
        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last super admin.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Display collaborations management page
     */
    public function collaborations(Request $request)
    {
        $query = Collaboration::with('creator');

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $collaborations = $query->paginate(15);

        return view('admin.collaborations.index', compact('collaborations'));
    }

    /**
     * Show collaboration details
     */
    public function showCollaboration(Collaboration $collaboration)
    {
        $collaboration->load(['creator', 'collaborationUsers.user', 'todos', 'comments']);
        return view('admin.collaborations.show', compact('collaboration'));
    }

    /**
     * Delete collaboration
     */
    public function deleteCollaboration(Collaboration $collaboration)
    {
        $collaboration->delete();
        return redirect()->route('admin.collaborations')->with('success', 'Collaboration deleted successfully.');
    }

    /**
     * Display events management page
     */
    public function events(Request $request)
    {
        $query = Event::with('creator');

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show event details
     */
    public function showEvent(Event $event)
    {
        $event->load(['creator', 'participants', 'categories']);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Delete event
     */
    public function deleteEvent(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully.');
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

        $connections = $query->paginate(15);

        return view('admin.connections.index', compact('connections'));
    }

    /**
     * Delete connection
     */
    public function deleteConnection(Connection $connection)
    {
        $connection->delete();
        return redirect()->route('admin.connections')->with('success', 'Connection deleted successfully.');
    }

    /**
     * Display interests management page
     */
    public function interests()
    {
        $interests = Interest::withCount('profiles')->paginate(15);
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
        $interest->delete();
        return redirect()->route('admin.interests')->with('success', 'Interest deleted successfully.');
    }

    /**
     * Display skills management page
     */
    public function skills()
    {
        $skills = Skill::withCount('profiles')->paginate(15);
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
        $skill->delete();
        return redirect()->route('admin.skills')->with('success', 'Skill deleted successfully.');
    }

    /**
     * Display contributions management page
     */
    public function contributions()
    {
        $contributions = Contribution::withCount('profiles')->paginate(15);
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
        $contribution->delete();
        return redirect()->route('admin.contributions')->with('success', 'Contribution deleted successfully.');
    }

    /**
     * Display event categories management page
     */
    public function eventCategories()
    {
        $categories = EventCategory::withCount('events')->paginate(15);
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
        $eventCategory->delete();
        return redirect()->route('admin.event-categories')->with('success', 'Event category deleted successfully.');
    }
}