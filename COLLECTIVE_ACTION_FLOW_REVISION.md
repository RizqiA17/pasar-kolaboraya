# Revisi Flow Aksi Kolektif - Invitation System

## 🎯 Perubahan Utama

Flow aksi kolektif telah direvisi dari sistem partisipasi langsung menjadi **invitation-based collaboration system** yang lebih realistis dan sesuai dengan cara kerja ecosystem builders di dunia nyata.

## 📋 Flow Baru

### 1. Diskusi dan Konsensus (Di Dunia Nyata)
- Ecosystem builders berdiskusi dan berkoordinasi secara offline
- Mereka sepakat untuk membuat aksi kolektif bersama
- Salah satu ecosystem builder ditunjuk untuk menjadi penyelenggara/coordinator

### 2. Pembuatan Aksi Kolektif
**Oleh: Ecosystem Builder yang ditunjuk**
- Membuat aksi kolektif dengan form yang telah direvisi
- **Tidak lagi memilih ecosystem secara langsung**
- Mengundang ecosystem builders lain yang ikut berdiskusi
- Mengirim invitation message yang personal

### 3. Respons Undangan
**Oleh: Ecosystem Builders yang diundang**
- Menerima notifikasi undangan di ecosystem dashboard
- Meninjau detail aksi kolektif dan syarat kolaborasi
- Memberikan respons: Terima atau Tolak
- Dapat memberikan pesan respons

### 4. Kolaborasi Aktif
**Setelah minimum 3 ecosystem menerima undangan:**
- Aksi kolektif dapat dimulai
- User biasa dapat berkontribusi
- Ecosystem builders mengelola aksi bersama

## 🛠️ Implementasi Teknis

### Database Changes

#### 1. Collective Actions Table
**Removed:**
- `ecosystem_ids` (JSON array)

**Maintained:**
- Semua field lainnya tetap sama

#### 2. New Table: `collective_action_ecosystem_invitations`
```sql
- id
- collective_action_id (FK)
- ecosystem_id (FK) 
- invited_by (FK to users)
- status (pending/accepted/declined)
- invitation_message (text)
- response_message (text)
- responded_at (timestamp)
- created_at, updated_at
```

### Model Updates

#### CollectiveAction Model
**New Methods:**
- `invitations()` - Get all invitations
- `acceptedInvitations()` - Get accepted invitations only
- `pendingInvitations()` - Get pending invitations
- `participatingEcosystems()` - Get ecosystems via accepted invitations
- `hasInvitedEcosystem($id)` - Check if ecosystem is invited
- `getEcosystemInvitationStatus($id)` - Get invitation status

#### Ecosystem Model
**New Methods:**
- `collectiveActionInvitations()` - Get all invitations for this ecosystem
- `acceptedCollectiveActions()` - Get accepted collective action invitations
- `pendingCollectiveActionInvitations()` - Get pending invitations

#### New Model: CollectiveActionEcosystemInvitation
**Features:**
- Complete invitation management
- Status tracking (pending/accepted/declined)
- Response messaging
- Invitation history

### UI Components

#### 1. Collective Action Creation Form
**Updated Features:**
- Select ecosystems to invite (not participate directly)
- Custom invitation messages for each ecosystem
- Remove minimum ecosystem requirement from form
- Focus on invitation rather than participation

#### 2. Ecosystem Dashboard - New "Undangan Aksi" Tab
**Features:**
- View pending invitations
- See invitation details and messages
- Quick access to respond to invitations
- Notification badges for pending invitations

#### 3. Invitation Response Interface
**Features:**
- Detailed view of collective action
- Collaboration terms review
- Accept/Decline with optional response message
- Full invitation context

### Routes Added

```php
// Respond to collective action invitation
Route::get('collective-actions/invitations/{invitation}/respond', 
    RespondInvitation::class)->name('collective-action.respond-invitation');
```

## 🔄 User Experience Flow

### For Ecosystem Builder (Inviter):
1. **Create Action** → Select ecosystems to invite → Write invitation messages
2. **Send Invitations** → Wait for responses from invited ecosystems
3. **Monitor Responses** → Track acceptance status in dashboard
4. **Launch Action** → Once minimum ecosystems accept

### For Ecosystem Builder (Invitee):
1. **Receive Notification** → See invitation in ecosystem dashboard
2. **Review Details** → Read invitation message and action details
3. **Make Decision** → Accept or decline with optional message
4. **Collaborate** → If accepted, participate in action management

### For Regular Users:
1. **Browse Actions** → See active collective actions
2. **Contribute** → Offer contributions to actions they're interested in
3. **Participate** → Get approved and contribute to the action

## 📊 Benefits of New Flow

### 1. Realistic Workflow
- Mirrors real-world collaboration processes
- Respects ecosystem autonomy and decision-making
- Allows for proper consultation and consensus

### 2. Better Communication
- Personal invitation messages
- Response tracking and feedback
- Clear collaboration terms upfront

### 3. Improved Management
- Clear invitation status tracking
- Organized dashboard for ecosystem builders
- Proper notification system

### 4. Scalable System
- Can handle multiple simultaneous invitations
- Flexible invitation criteria
- Proper audit trail for collaborations

## 🎉 Implementation Status

✅ **Completed:**
- Database schema updates and migrations
- Model relationships and business logic
- Invitation management system
- Creation form with invitation flow
- Response interface for ecosystem builders
- Dashboard integration with notifications
- Browse view updates for new ecosystem counting

🔧 **Technical Details:**
- Invitation system with proper foreign key relationships
- Status tracking (pending/accepted/declined)
- Message exchange between ecosystem builders
- Integration with existing user contribution system
- Maintains backward compatibility with user contributions

The new invitation-based flow provides a more realistic and manageable approach to collective action collaboration while maintaining all the core functionality for user participation and contribution.
