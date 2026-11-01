{{-- A starting point built from free OmniaUI components: KPI tiles, a line chart (inline SVG, no JavaScript), a table
     and status rows. Replace the sample numbers with your own data. --}}
<x-layouts::app :title="__('Dashboard')">
    <div class="app-dashboard">
        <x-oc::heading :title="__('Welcome back, :name', ['name' => auth()->user()->name])" :description="__('Here is what happens in your app today.')" :level="1" />

        <div class="oc-stat-card-grid">
            <x-oc::stat-card value="2,481" :label="__('Visitors')" trend="+12%" tone="accent" stripe>
                <x-slot:icon><x-icon name="mdi:account-multiple-outline" /></x-slot:icon>
            </x-oc::stat-card>
            <x-oc::stat-card value="€ 18,240" :label="__('Revenue')" trend="+4.6%" tone="success" stripe>
                <x-slot:icon><x-icon name="mdi:chart-bar" /></x-slot:icon>
            </x-oc::stat-card>
            <x-oc::stat-card value="312" :label="__('Messages')" trend="-3%" down tone="warning" stripe>
                <x-slot:icon><x-icon name="mdi:email-outline" /></x-slot:icon>
            </x-oc::stat-card>
        </div>

        <div class="app-dashboard-grid">
            <div class="oc-card">
                <div class="oc-card-content">
                    <x-oc::chart-line
                        :title="__('Visitors')"
                        :sub="__('Last six months')"
                        value="2,481"
                        variant="area"
                        :series="[
                            ['name' => __('Desktop'), 'values' => [186, 305, 237, 273, 309, 354]],
                            ['name' => __('Mobile'), 'values' => [80, 200, 160, 190, 230, 262]],
                        ]"
                    />
                </div>
            </div>

            <div class="oc-card">
                <div class="oc-card-header">
                    <h2 class="oc-card-title">{{ __('System status') }}</h2>
                    <p class="oc-card-description">{{ __('Background work of this app') }}</p>
                </div>
                <div class="oc-card-content flex flex-col gap-1">
                    <x-oc::status tone="done" meta="06:30">{{ __('Nightly backup finished') }}</x-oc::status>
                    <x-oc::status tone="working" :meta="__('now')">{{ __('Sending the newsletter') }}</x-oc::status>
                    <x-oc::status tone="waiting" meta="2">{{ __('Jobs in the queue') }}</x-oc::status>
                    <x-oc::progress :value="68" :label="__('Storage used')" levels />
                </div>
            </div>
        </div>

        <div class="oc-card">
            <div class="oc-card-header">
                <h2 class="oc-card-title">{{ __('Recent sign-ups') }}</h2>
            </div>
            <div class="oc-card-content">
                <x-oc::table striped>
                    <thead>
                        <tr><th>{{ __('Name') }}</th><th>{{ __('Plan') }}</th><th>{{ __('Status') }}</th><th class="text-right">{{ __('Joined') }}</th></tr>
                    </thead>
                    <tbody>
                        @foreach ([['Ada Lovelace', 'Team', 'success', __('Active')], ['Alan Turing', 'Pro', 'success', __('Active')], ['Grace Hopper', 'Free', 'warning', __('Trial')], ['Linus Torvalds', 'Pro', 'secondary', __('Invited')]] as $i => [$name, $plan, $variant, $state])
                            <tr>
                                <td><x-oc::user :name="$name" size="sm" /></td>
                                <td>{{ $plan }}</td>
                                <td><x-oc::badge :variant="$variant">{{ $state }}</x-oc::badge></td>
                                <td class="text-right">{{ now()->subDays($i * 3)->toDateString() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-oc::table>
            </div>
        </div>
    </div>
</x-layouts::app>
