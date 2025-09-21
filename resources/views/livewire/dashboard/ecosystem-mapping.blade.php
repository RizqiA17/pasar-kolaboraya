<div
    class="relative overflow-hidden rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-gray-100 dark:border-gray-700">
    <div
        class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-purple-50/50 dark:from-blue-900/10 dark:to-purple-900/10">
    </div>

    <!-- Header -->
    <div class="relative z-10 p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-2">
                    Peta Ekosistem Kolaboraya
                </h3>
                <p class="text-gray-600 dark:text-slate-400 text-sm">
                    Visualisasi interaktif ekosistem dan peran dalam {{ $pasarKolaboraya->name ?? 'Pasar Kolaboraya' }}
                </p>
            </div>
            <div
                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Mapping Container -->
    <div class="relative z-10 p-6">
         @if ($pasarKolaboraya && count($ecosystems) > 0)
             <div class="w-full h-[800px] bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden">
                 <div id="ecosystem-mapping-container" class="w-full h-full"></div>
             </div>

             <!-- Legend -->
             <div class="mt-4 flex flex-wrap gap-4 text-xs">
                 <div class="flex items-center gap-2">
                     <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                     <span class="text-gray-600 dark:text-gray-400">Pasar Kolaboraya</span>
                 </div>
                 <div class="flex items-center gap-2">
                     <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                     <span class="text-gray-600 dark:text-gray-400">Ekosistem</span>
                 </div>
                 <div class="flex items-center gap-2">
                     <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                     <span class="text-gray-600 dark:text-gray-400">Peran</span>
                 </div>
             </div>
        @else
            <div class="flex flex-col items-center justify-center h-96 text-center">
                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Ekosistem</h4>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Bergabunglah dengan ekosistem untuk melihat peta
                    kolaborasi</p>
                <a href="{{ route('ecosystem.browse') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Jelajahi Ekosistem
                </a>
            </div>
        @endif
    </div>
</div>

@if ($pasarKolaboraya && count($ecosystems) > 0)
    @push('scripts')
        <script src="https://d3js.org/d3.v7.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const data = {
                    pasarKolaboraya: {
                        id: @json($pasarKolaboraya->id),
                        name: @json($pasarKolaboraya->name),
                        description: @json($pasarKolaboraya->description),
                    },
                    ecosystems: @json($roleData),
                };

                createEcosystemMapping(data);
            });

             function createEcosystemMapping(data) {
                 const container = d3.select('#ecosystem-mapping-container');
                 const width = container.node().offsetWidth;
                 const height = container.node().offsetHeight;

                 // Clear previous content
                 container.selectAll('*').remove();

                 // Create SVG
                 const svg = container.append('svg')
                     .attr('width', width)
                     .attr('height', height)
                     .style('background', 'transparent');

                 // Create zoom behavior
                 const zoom = d3.zoom()
                     .scaleExtent([0.1, 4])
                     .on('zoom', (event) => {
                         g.attr('transform', event.transform);
                     });

                 svg.call(zoom);

                 // Main group for all elements
                 const g = svg.append('g');

                 // Center point
                 const centerX = width / 2;
                 const centerY = height / 2;

                 // Create central Pasar Kolaboraya node
                 const centralNode = g.append('g')
                     .attr('class', 'central-node')
                     .attr('transform', `translate(${centerX}, ${centerY})`);

                 // Create ecosystem nodes
                 const ecosystems = data.ecosystems;
                 
                 // Dynamic sizing based on data count
                 let centralRadius, ecosystemRadius, roleRadius, ecosystemTextSize, roleTextSize, maxEcosystemTextLength, maxRoleTextLength;
                 
                 if (ecosystems.length <= 3) {
                     centralRadius = 80;
                     ecosystemRadius = 50;
                     roleRadius = 22;
                     ecosystemTextSize = '14';
                     roleTextSize = '10';
                     maxEcosystemTextLength = 18;
                     maxRoleTextLength = 12;
                 } else if (ecosystems.length <= 6) {
                     centralRadius = 90;
                     ecosystemRadius = 55;
                     roleRadius = 24;
                     ecosystemTextSize = '12';
                     roleTextSize = '9';
                     maxEcosystemTextLength = 15;
                     maxRoleTextLength = 10;
                 } else if (ecosystems.length <= 10) {
                     centralRadius = 100;
                     ecosystemRadius = 60;
                     roleRadius = 26;
                     ecosystemTextSize = '11';
                     roleTextSize = '8';
                     maxEcosystemTextLength = 12;
                     maxRoleTextLength = 8;
                 } else {
                     centralRadius = 110;
                     ecosystemRadius = 65;
                     roleRadius = 28;
                     ecosystemTextSize = '10';
                     roleTextSize = '7';
                     maxEcosystemTextLength = 10;
                     maxRoleTextLength = 6;
                 }

                 // Central circle
                 centralNode.append('circle')
                     .attr('r', centralRadius)
                     .attr('fill', '#3B82F6')
                     .attr('stroke', '#1E40AF')
                     .attr('stroke-width', 3)
                     .style('filter', 'drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1))');

                 // Central text
                 centralNode.append('text')
                     .attr('text-anchor', 'middle')
                     .attr('dy', '-0.3em')
                     .attr('fill', 'white')
                     .attr('font-size', ecosystemTextSize)
                     .attr('font-weight', 'bold')
                     .text('PASAR');

                 centralNode.append('text')
                     .attr('text-anchor', 'middle')
                     .attr('dy', '1em')
                     .attr('fill', 'white')
                     .attr('font-size', ecosystemTextSize)
                     .attr('font-weight', 'bold')
                     .text('KOLABORAYA');

                 // Calculate dynamic radius based on ecosystem count and container size
                 const angleStep = (2 * Math.PI) / Math.max(ecosystems.length, 1);
                 
                 // Calculate minimum radius needed to fit all ecosystems without overlap
                 const minRadius = centralRadius + ecosystemRadius + 80; // 80px buffer for much more space
                 const maxRadius = Math.min(width, height) * 0.5; // Maximum 50% of container
                 const radius = Math.max(minRadius, Math.min(maxRadius, Math.min(width, height) * 0.45));

                 ecosystems.forEach((ecosystem, index) => {
                     const angle = index * angleStep;
                     const x = centerX + Math.cos(angle) * radius;
                     const y = centerY + Math.sin(angle) * radius;

                     const ecosystemGroup = g.append('g')
                         .attr('class', 'ecosystem-group')
                         .attr('transform', `translate(${x}, ${y})`);

                     // Ecosystem circle
                     ecosystemGroup.append('circle')
                         .attr('r', ecosystemRadius)
                         .attr('fill', '#10B981')
                         .attr('stroke', '#059669')
                         .attr('stroke-width', 2)
                         .style('filter', 'drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1))')
                         .on('mouseover', function() {
                             d3.select(this).attr('r', ecosystemRadius + 5);
                             showEcosystemTooltip(ecosystem, event);
                         })
                         .on('mouseout', function() {
                             d3.select(this).attr('r', ecosystemRadius);
                             hideEcosystemTooltip();
                         });

                     // Ecosystem text
                     ecosystemGroup.append('text')
                         .attr('text-anchor', 'middle')
                         .attr('dy', '0.3em')
                         .attr('fill', 'white')
                         .attr('font-size', ecosystemTextSize)
                         .attr('font-weight', 'bold')
                         .text(ecosystem.ecosystem.name.length > maxEcosystemTextLength ?
                             ecosystem.ecosystem.name.substring(0, maxEcosystemTextLength) + '...' :
                             ecosystem.ecosystem.name);

                     // Create role nodes around ecosystem
                     const roles = ecosystem.roles;
                     if (roles.length > 0) {
                         const roleAngleStep = (2 * Math.PI) / roles.length;
                         
                         // Dynamic role radius based on number of roles and ecosystem size
                         let roleCircleRadius;
                         if (roles.length <= 2) {
                             roleCircleRadius = ecosystemRadius * 0.6; // 60% of ecosystem radius
                         } else if (roles.length <= 4) {
                             roleCircleRadius = ecosystemRadius * 0.7; // 70% of ecosystem radius
                         } else if (roles.length <= 6) {
                             roleCircleRadius = ecosystemRadius * 0.8; // 80% of ecosystem radius
                         } else {
                             roleCircleRadius = ecosystemRadius * 0.9; // 90% of ecosystem radius
                         }

                         roles.forEach((role, roleIndex) => {
                             const roleAngle = roleIndex * roleAngleStep;
                             const roleX = Math.cos(roleAngle) * roleCircleRadius;
                             const roleY = Math.sin(roleAngle) * roleCircleRadius;

                             const roleGroup = ecosystemGroup.append('g')
                                 .attr('class', 'role-group')
                                 .attr('transform', `translate(${roleX}, ${roleY})`);

                             // Role circle
                             roleGroup.append('circle')
                                 .attr('r', roleRadius)
                                 .attr('fill', '#F59E0B')
                                 .attr('stroke', '#D97706')
                                 .attr('stroke-width', 1)
                                 .style('filter', 'drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1))')
                                 .on('mouseover', function(event) {
                                     d3.select(this).attr('r', roleRadius + 4);
                                     showRoleTooltip(role, event);
                                 })
                                 .on('mouseout', function() {
                                     d3.select(this).attr('r', roleRadius);
                                     hideRoleTooltip();
                                 });

                             // Role text
                             roleGroup.append('text')
                                 .attr('text-anchor', 'middle')
                                 .attr('dy', '0.3em')
                                 .attr('fill', 'white')
                                 .attr('font-size', roleTextSize)
                                 .attr('font-weight', 'bold')
                                 .text(role.role.length > maxRoleTextLength ?
                                     role.role.substring(0, maxRoleTextLength) + '...' :
                                     role.role);

                             // Role count
                             roleGroup.append('text')
                                 .attr('text-anchor', 'middle')
                                 .attr('dy', '1.4em')
                                 .attr('fill', 'white')
                                 .attr('font-size', parseInt(roleTextSize) - 2)
                                 .text(role.count);
                         });
                     }

                     // Draw line from center to ecosystem
                     g.append('line')
                         .attr('x1', centerX)
                         .attr('y1', centerY)
                         .attr('x2', x)
                         .attr('y2', y)
                         .attr('stroke', '#94A3B8')
                         .attr('stroke-width', 2)
                         .attr('opacity', 0.6);
                 });

                 // Tooltip for ecosystem details
                 const ecosystemTooltip = d3.select('body').append('div')
                     .attr('class', 'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                     .style('opacity', 0);

                 function showEcosystemTooltip(ecosystem, event) {
                     ecosystemTooltip
                         .html(`
                             <div class="font-bold mb-2">${ecosystem.ecosystem.name}</div>
                             <div class="text-xs text-gray-300 mb-1">${ecosystem.ecosystem.organization || 'Organisasi'}</div>
                             <div class="text-xs text-gray-400">${ecosystem.totalUsers} pengguna • ${ecosystem.roles.length} peran</div>
                         `)
                         .style('left', (event.pageX) + 'px')
                         .style('top', (event.pageY) + 'px')
                         .style('opacity', 1);
                 }

                 function hideEcosystemTooltip() {
                     ecosystemTooltip.style('opacity', 0);
                 }

                 // Tooltip for role details
                 const roleTooltip = d3.select('body').append('div')
                     .attr('class', 'absolute z-50 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg pointer-events-none')
                     .style('opacity', 0);

                 function showRoleTooltip(role, event) {
                     const users = role.users.map(user => user.name).join(', ');
                     roleTooltip
                         .html(`
                             <div class="font-bold mb-2">${role.role}</div>
                             <div class="text-xs text-gray-300 mb-1">${role.count} pengguna</div>
                             <div class="text-xs text-gray-400">${users}</div>
                         `)
                         .style('left', (event.pageX + 10) + 'px')
                         .style('top', (event.pageY) + 'px')
                         .style('opacity', 1);
                 }

                 function hideRoleTooltip() {
                     roleTooltip.style('opacity', 0);
                 }

                 // Initial zoom to fit all content with proper spacing
                 setTimeout(() => {
                     const bounds = g.node().getBBox();
                     const padding = 100; // Increased padding for more breathing room
                     const fullWidth = bounds.width + padding * 2;
                     const fullHeight = bounds.height + padding * 2;
                     const scale = Math.min(width / fullWidth, height / fullHeight, 0.8); // Reduced scale for more space
                     const translate = [width / 2 - scale * (bounds.x + bounds.width / 2),
                         height / 2 - scale * (bounds.y + bounds.height / 2)
                     ];

                     svg.call(zoom.transform, d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale));
                 }, 100);
             }
        </script>
    @endpush
@endif
