<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Testing Dashboard - Pasar Kolaboraya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div id="app" class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">📧 Email Testing Dashboard</h1>
            <p class="text-gray-600">Test dan preview semua template email Pasar Kolaboraya</p>
        </div>

        <!-- Template Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Verification Emails -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">🔐</span>
                    Verification Emails
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('email.preview.reset-password') }}" 
                       class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Preview Reset Password
                    </a>
                </div>
            </div>

            <!-- Collaboration Emails -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">🤝</span>
                    Collaboration Emails
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('email.preview.collaboration-invitation') }}" 
                       class="block w-full bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Preview Invitation
                    </a>
                    <a href="{{ route('email.preview.collaboration-status') }}" 
                       class="block w-full bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Preview Status Update
                    </a>
                </div>
            </div>

            <!-- General Emails -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">📧</span>
                    General Emails
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('email.preview.welcome') }}" 
                       class="block w-full bg-purple-500 hover:bg-purple-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Preview Welcome Email
                    </a>
                </div>
            </div>

            <!-- Event Emails -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">📅</span>
                    Event Emails
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('email.preview.event') }}" 
                       class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Preview Event Notification
                    </a>
                </div>
            </div>

            <!-- Connection Emails -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">👥</span>
                    Connection Emails
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('email.preview.connection') }}" 
                       class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Preview New Connection
                    </a>
                </div>
            </div>

            <!-- Testing Tools -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">🧪</span>
                    Testing Tools
                </h3>
                <div class="space-y-3">
                    <button @click="showTestForm = true" 
                            class="w-full bg-red-500 hover:bg-red-600 text-white text-center py-2 px-4 rounded transition-colors">
                        Test Email Sending
                    </button>
                </div>
            </div>
        </div>

        <!-- Test Results -->
        <div v-if="testResults.length > 0" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">📊 Test Results</h3>
            <div class="space-y-3">
                <div v-for="result in testResults" :key="result.id" 
                     :class="result.success ? 'bg-green-100 border-green-300' : 'bg-red-100 border-red-300'"
                     class="border rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium" :class="result.success ? 'text-green-800' : 'text-red-800'">
                                @{{ result.message }}
                            </p>
                            <p class="text-sm text-gray-600">@{{ result.timestamp }}</p>
                        </div>
                        <span :class="result.success ? 'text-green-600' : 'text-red-600'" class="text-2xl">
                            @{{ result.success ? '✅' : '❌' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Form Modal -->
        <div v-if="showTestForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">🧪 Test Email Sending</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Type</label>
                        <select v-model="testForm.type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="welcome">Welcome Email</option>
                            <option value="event-notification">Event Notification</option>
                            <option value="new-connection">New Connection</option>
                            <option value="collaboration-invitation">Collaboration Invitation</option>
                            <option value="collaboration-status-update">Collaboration Status Update</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User ID</label>
                        <input type="number" v-model="testForm.userId" placeholder="1" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div v-if="testForm.type === 'event-notification'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event ID</label>
                        <input type="number" v-model="testForm.eventId" placeholder="1" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div v-if="testForm.type === 'new-connection'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Connection ID</label>
                        <input type="number" v-model="testForm.connectionId" placeholder="1" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div v-if="testForm.type === 'collaboration-invitation'">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Collaboration ID</label>
                                <input type="number" v-model="testForm.collaborationId" placeholder="1" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Inviter ID</label>
                                <input type="number" v-model="testForm.inviterId" placeholder="1" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <div v-if="testForm.type === 'collaboration-status-update'">
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Collaboration ID</label>
                                <input type="number" v-model="testForm.collaborationId" placeholder="1" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select v-model="testForm.status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <option value="accepted">Accepted</option>
                                    <option value="declined">Declined</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                                <select v-model="testForm.action" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <option value="accepted">Accepted</option>
                                    <option value="declined">Declined</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button @click="runTest" 
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition-colors">
                        Run Test
                    </button>
                    <button @click="showTestForm = false" 
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-3">📖 Cara Penggunaan</h3>
            <div class="text-blue-700 space-y-2">
                <p><strong>1. Preview Templates:</strong> Klik tombol preview untuk melihat tampilan email tanpa mengirim</p>
                <p><strong>2. Test Email Sending:</strong> Gunakan form testing untuk mengirim email dengan data dummy</p>
                <p><strong>3. Environment:</strong> Routes ini hanya aktif di environment development</p>
                <p><strong>4. Data Dummy:</strong> Semua test menggunakan data dummy yang aman</p>
            </div>
        </div>
    </div>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    showTestForm: false,
                    testResults: [],
                    testForm: {
                        type: 'welcome',
                        userId: 1,
                        eventId: 1,
                        connectionId: 1,
                        collaborationId: 1,
                        inviterId: 1,
                        status: 'accepted',
                        action: 'accepted'
                    }
                }
            },
            methods: {
                async runTest() {
                    try {
                        const endpoint = this.getTestEndpoint();
                        const data = this.getTestData();
                        
                        const response = await axios.post(endpoint, data);
                        
                        this.testResults.unshift({
                            id: Date.now(),
                            success: true,
                            message: response.data.message,
                            timestamp: new Date().toLocaleTimeString()
                        });
                        
                        this.showTestForm = false;
                    } catch (error) {
                        this.testResults.unshift({
                            id: Date.now(),
                            success: false,
                            message: error.response?.data?.error || 'Test failed',
                            timestamp: new Date().toLocaleTimeString()
                        });
                    }
                },
                getTestEndpoint() {
                    const endpoints = {
                        'welcome': '{{ route("email.test.welcome") }}',
                        'event-notification': '{{ route("email.test.event") }}',
                        'new-connection': '{{ route("email.test.connection") }}',
                        'collaboration-invitation': '{{ route("email.test.collaboration-invitation") }}',
                        'collaboration-status-update': '{{ route("email.test.collaboration-status") }}'
                    };
                    return endpoints[this.testForm.type];
                },
                getTestData() {
                    const baseData = { user_id: this.testForm.userId };
                    
                    switch (this.testForm.type) {
                        case 'event-notification':
                            return { ...baseData, event_id: this.testForm.eventId };
                        case 'new-connection':
                            return { ...baseData, connection_id: this.testForm.connectionId };
                        case 'collaboration-invitation':
                            return { 
                                ...baseData, 
                                collaboration_id: this.testForm.collaborationId,
                                inviter_id: this.testForm.inviterId,
                                invitee_id: this.testForm.userId
                            };
                        case 'collaboration-status-update':
                            return { 
                                ...baseData, 
                                collaboration_id: this.testForm.collaborationId,
                                status: this.testForm.status,
                                action: this.testForm.action
                            };
                        default:
                            return baseData;
                    }
                }
            }
        }).mount('#app');
    </script>
</body>
</html>
