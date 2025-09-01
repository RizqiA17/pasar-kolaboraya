<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Collaboration;
use App\Models\Event;
use App\Models\Connection;
use App\Notifications\WelcomeEmailNotification;
use App\Notifications\EventNotificationCustom;
use App\Notifications\NewConnectionNotificationCustom;
use App\Notifications\CollaborationInvitationCustom;
use App\Notifications\CollaborationStatusUpdateCustom;

class ExampleEmailController extends Controller
{
    /**
     * Contoh pengiriman welcome email
     */
    public function sendWelcomeEmail(Request $request)
    {
        $user = User::find($request->user_id);
        
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }
        
        // Kirim welcome email
        $user->notify(new WelcomeEmailNotification($user));
        
        return response()->json([
            'message' => 'Welcome email berhasil dikirim ke ' . $user->email,
            'user' => $user->name
        ]);
    }
    
    /**
     * Contoh pengiriman notifikasi event
     */
    public function sendEventNotification(Request $request)
    {
        $event = Event::with('category', 'organizer')->find($request->event_id);
        $user = User::find($request->user_id);
        
        if (!$event || !$user) {
            return response()->json(['error' => 'Event atau user tidak ditemukan'], 404);
        }
        
        // Kirim notifikasi event
        $user->notify(new EventNotificationCustom($event, $user));
        
        return response()->json([
            'message' => 'Event notification berhasil dikirim',
            'event' => $event->title,
            'user' => $user->name
        ]);
    }
    
    /**
     * Contoh pengiriman notifikasi koneksi baru
     */
    public function sendConnectionNotification(Request $request)
    {
        $connection = Connection::with(['requester', 'receiver'])->find($request->connection_id);
        $user = User::find($request->user_id);
        
        if (!$connection || !$user) {
            return response()->json(['error' => 'Connection atau user tidak ditemukan'], 404);
        }
        
        // Kirim notifikasi koneksi baru
        $user->notify(new NewConnectionNotificationCustom($connection, $user));
        
        return response()->json([
            'message' => 'Connection notification berhasil dikirim',
            'connection_id' => $connection->id,
            'user' => $user->name
        ]);
    }
    
    /**
     * Contoh pengiriman undangan kolaborasi
     */
    public function sendCollaborationInvitation(Request $request)
    {
        $collaboration = Collaboration::find($request->collaboration_id);
        $inviter = User::find($request->inviter_id);
        $invitee = User::find($request->invitee_id);
        
        if (!$collaboration || !$inviter || !$invitee) {
            return response()->json(['error' => 'Data tidak lengkap'], 404);
        }
        
        // Kirim undangan kolaborasi
        $invitee->notify(new CollaborationInvitationCustom($collaboration, $inviter));
        
        return response()->json([
            'message' => 'Collaboration invitation berhasil dikirim',
            'collaboration' => $collaboration->title,
            'inviter' => $inviter->name,
            'invitee' => $invitee->name
        ]);
    }
    
    /**
     * Contoh pengiriman update status kolaborasi
     */
    public function sendStatusUpdate(Request $request)
    {
        $collaboration = Collaboration::find($request->collaboration_id);
        $user = User::find($request->user_id);
        $status = $request->status; // 'accepted' atau 'declined'
        $action = $request->action; // 'accepted' atau 'declined'
        
        if (!$collaboration || !$user) {
            return response()->json(['error' => 'Data tidak lengkap'], 404);
        }
        
        // Kirim update status kolaborasi
        $user->notify(new CollaborationStatusUpdateCustom($collaboration, $user, $status, $action));
        
        return response()->json([
            'message' => 'Status update notification berhasil dikirim',
            'collaboration' => $collaboration->title,
            'user' => $user->name,
            'status' => $status
        ]);
    }
    
    /**
     * Contoh preview email template
     */
    public function previewEmailTemplate(Request $request)
    {
        $template = $request->template;
        $data = $request->data ?? [];
        
        // Data dummy untuk preview
        $dummyData = $this->getDummyData($template);
        
        // Merge dengan data yang dikirim
        $data = array_merge($dummyData, $data);
        
        switch ($template) {
            case 'welcome':
                return view('emails.general.welcome', $data);
                
            case 'event-notification':
                return view('emails.events.event-notification', $data);
                
            case 'new-connection':
                return view('emails.connections.new-connection', $data);
                
            case 'collaboration-invitation':
                return view('emails.collaboration.invitation', $data);
                
            case 'collaboration-status-update':
                return view('emails.collaboration.status-update', $data);
                
            case 'reset-password':
                return view('emails.auth.reset-password', $data);
                
            default:
                return response()->json(['error' => 'Template tidak ditemukan'], 404);
        }
    }
    
    /**
     * Generate dummy data untuk preview
     */
    private function getDummyData($template)
    {
        $dummyUser = (object) [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'profile' => (object) [
                'profession' => 'Software Developer',
                'company' => 'Tech Corp',
                'location' => 'Jakarta, Indonesia',
                'bio' => 'Passionate developer with 5+ years experience in web development.'
            ],
            'skills' => collect([
                (object) ['name' => 'PHP'],
                (object) ['name' => 'Laravel'],
                (object) ['name' => 'JavaScript'],
                (object) ['name' => 'Vue.js'],
                (object) ['name' => 'MySQL'],
                (object) ['name' => 'Git']
            ])
        ];
        
        $dummyCollaboration = (object) [
            'id' => 1,
            'title' => 'Project Management App',
            'description' => 'Membangun aplikasi manajemen project yang user-friendly dan powerful.',
            'category' => 'Technology'
        ];
        
        $dummyEvent = (object) [
            'id' => 1,
            'title' => 'Web Development Workshop',
            'description' => 'Workshop intensif untuk mempelajari web development modern.',
            'date' => now()->addDays(7),
            'location' => 'Jakarta Convention Center',
            'max_participants' => 50,
            'registration_deadline' => now()->addDays(5),
            'category' => (object) ['name' => 'Workshop'],
            'organizer' => (object) ['name' => 'Tech Community Jakarta']
        ];
        
        $dummyConnection = (object) [
            'id' => 1,
            'requester_id' => 1,
            'receiver_id' => 2,
            'status' => 'accepted'
        ];
        
        switch ($template) {
            case 'welcome':
                return ['user' => $dummyUser];
                
            case 'event-notification':
                return [
                    'user' => $dummyUser,
                    'event' => $dummyEvent
                ];
                
            case 'new-connection':
                return [
                    'notifiable' => $dummyUser,
                    'connection' => $dummyConnection,
                    'connectedUser' => $dummyUser
                ];
                
            case 'collaboration-invitation':
                return [
                    'notifiable' => $dummyUser,
                    'collaboration' => $dummyCollaboration,
                    'inviter' => $dummyUser
                ];
                
            case 'collaboration-status-update':
                return [
                    'notifiable' => $dummyUser,
                    'collaboration' => $dummyCollaboration,
                    'user' => $dummyUser,
                    'status' => 'accepted',
                    'action' => 'accepted'
                ];
                
            case 'reset-password':
                return [
                    'user' => $dummyUser,
                    'resetUrl' => 'https://example.com/reset-password?token=abc123'
                ];
                
            default:
                return [];
        }
    }
}
