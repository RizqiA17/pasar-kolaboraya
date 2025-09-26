<?php

namespace App\Livewire\CollectiveAction;

use Livewire\Component;
use App\Models\Ecosystem;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Auth;
use App\Models\CollectiveActionEcosystemInvitation;

#[Layout('components.layouts.app', ['title' => 'Buat Aksi Kolektif'])]
class Create extends Component
{
    public $title = '';
    public $description = '';
    public $scale = 'sedang';
    public $scope = 'local';
    public $goals = '';
    public $required_resources = [];
    public $invited_ecosystems = [];
    public $invitation_messages = [];
    public $start_date = '';
    public $end_date = '';
    public $location = '';
    public $latitude = null;
    public $longitude = null;
    public $min_ecosystems = 3;
    public $collaboration_terms = '';

    public $availableEcosystems = [];
    public $resourceTypes = [
        'dana' => 'Dana/Pendanaan',
        'keahlian' => 'Keahlian/Expertise',
        'relawan' => 'Relawan',
        'infrastruktur' => 'Infrastruktur',
        'promosi' => 'Promosi/Marketing',
        'teknologi' => 'Teknologi',
        'akses_pasar' => 'Akses Pasar',
        'relasi' => 'Relasi/Networking',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'scale' => 'required|in:kecil,sedang,besar',
        'scope' => 'required|in:local,national,international',
        'goals' => 'required|string',
        'invited_ecosystems' => 'required|array|min:2',
        'start_date' => 'required|date|after:today',
        'end_date' => 'required|date|after:start_date',
        'location' => 'nullable|string|max:255',
        'min_ecosystems' => 'required|integer|min:3',
        'collaboration_terms' => 'required|string',
        'required_resources' => 'required|array|min:1',
    ];

    protected $messages = [
        'title.required' => 'Judul aksi kolektif wajib diisi',
        'description.required' => 'Deskripsi wajib diisi',
        'goals.required' => 'Tujuan aksi wajib diisi',
        'invited_ecosystems.required' => 'Minimal undang 2 ekosistem lain',
        'invited_ecosystems.min' => 'Minimal undang 2 ekosistem lain untuk berkolaborasi',
        'start_date.required' => 'Tanggal mulai wajib diisi',
        'start_date.after' => 'Tanggal mulai harus setelah hari ini',
        'end_date.required' => 'Tanggal selesai wajib diisi',
        'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        'min_ecosystems.min' => 'Minimal ekosistem yang diperlukan adalah 3',
        'collaboration_terms.required' => 'Syarat kolaborasi wajib diisi',
        'required_resources.required' => 'Minimal pilih 1 jenis sumber daya yang dibutuhkan',
    ];

    public function mount()
    {
        // Check if user is ecosystem builder
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEcosystemBuilder()) {
            session()->flash('error', 'Hanya Ecosystem Builder yang dapat membuat aksi kolektif.');
            return redirect()->route('collective-action.browse');
        }

        // Get all active ecosystems except user's own ecosystems  
        // Filter by user's active session
        $user = Auth::user();
        $userEcosystemIds = $user->acceptedEcosystems->pluck('id')->toArray();
        $this->availableEcosystems = Ecosystem::where('is_active', true)
            ->forUserActiveSession($user) // Filter by user's active session
            ->whereNotIn('id', $userEcosystemIds)
            ->where('creator_id', '!=', Auth::id())
            ->get();

        // Set default date (tomorrow)
        $this->start_date = now()->addDay()->format('Y-m-d');
        $this->end_date = now()->addDays(30)->format('Y-m-d');
    }

    public function createAction()
    {
        // dd($creatorEcosystem = Auth::user()->acceptedEcosystems->first());
        $this->validate();

        // Set default location if not provided
        if (empty($this->location)) {
            $this->location = "Lokasi belum ditentukan";
        }

        $qrCode = '' . Str::random(6);

        while (CollectiveAction::where('qr_code', $qrCode)->exists()) {
            $qrCode = '' . Str::random(6);
        }

        // Create the collective action
        $action = CollectiveAction::create([
            'title' => $this->title,
            'description' => $this->description,
            'scale' => $this->scale,
            'scope' => $this->scope,
            'goals' => $this->goals,
            'required_resources' => $this->required_resources,
            'created_by' => Auth::id(),
            'pasar_kolaboraya_id' => Auth::user()->active_pasar_kolaboraya_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => 'planning',
            'min_ecosystems' => $this->min_ecosystems,
            'collaboration_terms' => $this->collaboration_terms,
            'qr_code' => $qrCode,
        ]);

        // Add creator as admin of the collective action
        // Get creator's ecosystem to associate with the collective action
        $creatorEcosystem = Auth::user()->createdEcosystems->first();
        $action->addUser(Auth::user(), 'admin', 'Creator of collective action', $creatorEcosystem->id);

        // Create invitation record for creator's ecosystem (auto-accepted)
        if ($creatorEcosystem) {
            CollectiveActionEcosystemInvitation::create([
                'collective_action_id' => $action->id,
                'ecosystem_id' => $creatorEcosystem->id,
                'invited_by' => Auth::id(),
                'status' => 'accepted', // Auto-accepted for creator
                'role' => 'admin',
                'invitation_message' => 'Creator of collective action',
                'response_message' => 'Auto-accepted as creator',
                'responded_at' => now(),
            ]);
        }

        // Auto-join ecosystems members if auto-join is enabled
        if ($creatorEcosystem->auto_join_collective_actions == 1) {
            $ecosystemsMembers = $creatorEcosystem->acceptedUsers()->get();

            $insertData = [];
            foreach ($ecosystemsMembers as $member) {
                // Hindari duplikasi jika user sudah terdaftar
                if (!$action->isUserMember($member) && !$action->isUserAdmin($member) && !$action->isUserContributor($member)) {
                    $insertData[$member->id] = [
                        'ecosystem_id' => $creatorEcosystem->id,
                        'role' => 'member',
                        'status' => $creatorEcosystem->auto_join_collective_actions ? 'active' : 'pending_approval',
                        'join_type' => 'ecosystem',
                        'join_reason' => 'Member of collective action',
                        'joined_at' => $creatorEcosystem->auto_join_collective_actions ? now() : null,
                        'approval_requested_at' => $creatorEcosystem->auto_join_collective_actions ? null : now(),
                    ];
                }
            }
            if (!empty($insertData)) {
                $action->users()->attach($insertData);
            }
        }

        // Send invitations to selected ecosystems
        $invitations = [];
        foreach ($this->invited_ecosystems as $ecosystemId) {
            $invitationMessage = $this->invitation_messages[$ecosystemId] ?? "Kami mengundang ekosistem Anda untuk berkolaborasi dalam aksi kolektif: {$this->title}";

            $invitations[] = [
                'collective_action_id' => $action->id,
                'ecosystem_id' => $ecosystemId,
                'invited_by' => Auth::id(),
                'status' => 'pending',
                'role' => 'admin', // Ecosystem builders become admins
                'invitation_message' => $invitationMessage,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (!empty($invitations)) {
            CollectiveActionEcosystemInvitation::insert($invitations);
        }

        session()->flash('message', 'Aksi kolektif berhasil dibuat dan undangan telah dikirim! Status: Perencanaan');

        return redirect()->route('collective-action.browse');
    }

    public function setCoordinates($data)
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }

    public function setLocation($data)
    {
        $this->location = $data['location'];
    }

    public function render()
    {
        return view('livewire.collective-action.create');
    }
}
