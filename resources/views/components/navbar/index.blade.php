@php
    $user = auth()->user();
    $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $ecosystemsEnabled = \App\Models\SystemSetting::isEcosystemsEnabled($user);
    $userActionsEnabled = \App\Models\SystemSetting::isUserActionsEnabled();
    $collectiveActionsEnabled = \App\Models\SystemSetting::isCollectiveActionsEnabled();
    $isSuperAdmin = $user->isSuperAdmin();
    $isEcosystemBuilder = $user->isApprovedEcosystemBuilder();
    $hasActiveMarketSession = $user->hasActivePasarKolaboraya();
@endphp
@include('components.navbar.desktop-navbar')
@include('components.navbar.mobile-navbar')