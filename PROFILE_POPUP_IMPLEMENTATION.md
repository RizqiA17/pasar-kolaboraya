# Profile Popup Implementation

## Overview
This feature adds a clickable profile popup card that appears when users click on someone else's profile name in various parts of the application. The popup shows detailed user information and provides connection management buttons similar to the suggestion component.

## Components Created

### 1. Livewire Component: `ProfileCard`
**File:** `app/Livewire/Profile/ProfileCard.php`

**Features:**
- Shows user profile information (name, email, organization, skills, interests, vision)
- Displays connection status and appropriate action buttons
- Handles all connection operations (connect, accept, reject, disconnect, start collaboration)
- Updates connection status in real-time
- Closes modal when clicking outside or on close button

**Methods:**
- `showProfile($userId)` - Opens the profile popup for a specific user
- `closeModal()` - Closes the popup
- `connect($userId)` - Sends connection request
- `acceptConnection($userId)` - Accepts incoming connection request
- `rejectConnection($userId)` - Rejects incoming connection request
- `startCollaboration($userId)` - Initiates collaboration
- `disconnect($userId)` - Disconnects from user
- `updateConnectionStatus($userId, $status)` - Updates connection status

### 2. Blade View: `profile-card.blade.php`
**File:** `resources/views/livewire/profile/profile-card.blade.php`

**Features:**
- Responsive modal design with backdrop
- User avatar with initials
- Cover image placeholder
- User information display
- Skills and interests tags (shows first 5 with count indicator)
- Vision statement (if available)
- Dynamic connection buttons based on status
- Smooth animations and hover effects

## Integration Points

### 1. Suggestion Component
**File:** `resources/views/livewire/connections/suggestion.blade.php`

**Changes Made:**
- Added `wire:click="$dispatch('showProfileCard', { userId: {{ $user->id }} })"` to user names
- Added `<livewire:profile.profile-card />` component
- Made user names clickable in:
  - Search results
  - Mutual friends recommendations
  - Interest-based recommendations
  - Event-based recommendations

### 2. List Connection Component
**File:** `resources/views/livewire/connections/list-connection.blade.php`

**Changes Made:**
- Added `wire:click="$dispatch('showProfileCard', { userId: {{ $friend['id'] }} })"` to friend names
- Added `<livewire:profile.profile-card />` component
- Made friend names clickable in both search results and regular connections list

## How to Use

### 1. Trigger the Popup
Click on any user's name in:
- Connection suggestions
- Connection list
- Search results
- Recommendations

### 2. Profile Information Displayed
- **Basic Info:** Name, email, organization
- **Skills:** Up to 5 skills with count indicator
- **Interests:** Up to 5 interests with count indicator
- **Vision:** Personal vision statement (if available)

### 3. Connection Actions Available
Based on connection status:

**Not Connected:**
- "Tambah Koneksi" button

**Pending Sent:**
- "Menunggu Konfirmasi" (disabled)

**Pending Received:**
- "Terima Permintaan" button
- "Tolak Permintaan" button

**Connected:**
- "Mulai Kolaborasi" button
- "Putuskan Koneksi" button

## Technical Details

### Event System
- Uses Livewire's `$dispatch()` method to trigger popup
- Event name: `showProfileCard`
- Payload: `{ userId: number }`

### Connection Status Management
- Integrates with existing `getConnectionStatus()` method from User model
- Real-time updates using Livewire events
- Consistent with existing connection button behavior

### Responsive Design
- Mobile-first approach
- Maximum width: `max-w-md`
- Maximum height: `max-h-[90vh]` with scroll
- Backdrop click to close
- Escape key support (Livewire default)

## Styling

### Color Scheme
- **Primary:** Blue (#3B82F6) for connect actions
- **Success:** Green (#059669) for accept/collaboration actions
- **Danger:** Red (#DC2626) for reject/disconnect actions
- **Neutral:** Gray for disabled states

### Visual Elements
- Gradient backgrounds for avatars and cover images
- Rounded corners and shadows for modern look
- Hover effects and transitions
- Consistent spacing and typography

## Future Enhancements

1. **Profile Images:** Support for actual profile and cover photos
2. **Social Media Links:** Display social media profiles
3. **Activity Feed:** Show recent activities or posts
4. **Mutual Connections:** Display mutual friends count
5. **Message Feature:** Direct messaging capability
6. **Profile Verification:** Badge for verified profiles

## Testing

To test the profile popup:

1. Navigate to `/connections` route
2. Click on any user's name in suggestions or connections
3. Verify popup appears with correct information
4. Test connection actions (connect, accept, reject, etc.)
5. Verify popup closes properly
6. Test on different screen sizes for responsiveness

## Dependencies

- Laravel Livewire
- Tailwind CSS
- Existing User and Connection models
- Profile, Skill, and Interest relationships
