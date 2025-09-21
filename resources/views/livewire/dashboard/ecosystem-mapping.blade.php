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

<!-- Ecosystem Detail Modal -->
@include('components.ecosystem-detail-modal')

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

                 // Helper function for text wrapping
                 function wrapText(text, maxWidth, fontSize) {
                     const words = text.split(' ');
                     const lines = [];
                     let currentLine = '';
                     
                     words.forEach(word => {
                         const testLine = currentLine + (currentLine ? ' ' : '') + word;
                         const testWidth = testLine.length * fontSize * 0.6; // Approximate character width
                         
                         if (testWidth <= maxWidth) {
                             currentLine = testLine;
                         } else {
                             if (currentLine) lines.push(currentLine);
                             currentLine = word;
                         }
                     });
                     if (currentLine) lines.push(currentLine);
                     
                     return lines;
                 }
                 
                 // Create gradients and filters
                 const defs = svg.append('defs');
                 
                 // Central gradient
                 const centralGradient = defs.append('radialGradient')
                     .attr('id', 'centralGradient')
                     .attr('cx', '30%')
                     .attr('cy', '30%')
                     .attr('r', '70%');
                 
                 centralGradient.append('stop')
                     .attr('offset', '0%')
                     .attr('stop-color', '#60A5FA');
                 
                 centralGradient.append('stop')
                     .attr('offset', '100%')
                     .attr('stop-color', '#1E40AF');
                 
                 // Ecosystem gradient
                 const ecosystemGradient = defs.append('radialGradient')
                     .attr('id', 'ecosystemGradient')
                     .attr('cx', '30%')
                     .attr('cy', '30%')
                     .attr('r', '70%');
                 
                 ecosystemGradient.append('stop')
                     .attr('offset', '0%')
                     .attr('stop-color', '#34D399');
                 
                 ecosystemGradient.append('stop')
                     .attr('offset', '100%')
                     .attr('stop-color', '#059669');
                 
                 // Role gradient
                 const roleGradient = defs.append('radialGradient')
                     .attr('id', 'roleGradient')
                     .attr('cx', '30%')
                     .attr('cy', '30%')
                     .attr('r', '70%');
                 
                 roleGradient.append('stop')
                     .attr('offset', '0%')
                     .attr('stop-color', '#F59E0B');
                 
                 roleGradient.append('stop')
                     .attr('offset', '100%')
                     .attr('stop-color', '#D97706');
                 
                 // Shadow filter
                 const shadowFilter = defs.append('filter')
                     .attr('id', 'shadow')
                     .attr('x', '-50%')
                     .attr('y', '-50%')
                     .attr('width', '200%')
                     .attr('height', '200%');
                 
                 shadowFilter.append('feDropShadow')
                     .attr('dx', 4)
                     .attr('dy', 4)
                     .attr('stdDeviation', 4)
                     .attr('flood-color', 'rgba(0,0,0,0.25)');
                 
                 // Calculate dynamic radius based on ecosystem count and container size
                 const totalEcosystems = Math.max(ecosystems.length, 1);
                 const angleStep = (2 * Math.PI) / totalEcosystems;
                 
                 // Calculate minimum distance between ecosystem centers to prevent overlap
                 const minDistanceBetweenEcosystems = (ecosystemRadius * 2) + 80; // 80px minimum gap between bubbles
                 
                 // Calculate the required radius to fit all ecosystems with equal spacing
                 // Using the formula: circumference = 2 * π * radius
                 // We need: circumference / totalEcosystems >= minDistanceBetweenEcosystems
                 // So: radius >= (minDistanceBetweenEcosystems * totalEcosystems) / (2 * π)
                 const requiredRadius = (minDistanceBetweenEcosystems * totalEcosystems) / (2 * Math.PI);
                 
                 // MUCH LARGER padding from the center circle - this is the key to wider spacing
                 const centerPadding = centralRadius + ecosystemRadius + 200; // Increased from 120 to 200
                 
                 // Calculate maximum allowed radius (70% of container - increased from 60%)
                 const maxRadius = Math.min(width, height) * 0.7;
                 
                 // Use the larger of required radius or center padding, but not exceeding max radius
                 const radius = Math.min(Math.max(requiredRadius, centerPadding), maxRadius);

                 // FIRST: Draw all lines from center to ecosystems (behind everything)
                 ecosystems.forEach((ecosystem, index) => {
                     const angle = index * angleStep;
                     const x = centerX + Math.cos(angle) * radius;
                     const y = centerY + Math.sin(angle) * radius;

                     // Draw line from center to ecosystem with solid color for better visibility
                     g.append('line')
                         .attr('x1', centerX)
                         .attr('y1', centerY)
                         .attr('x2', x)
                         .attr('y2', y)
                         .attr('stroke', '#3B82F6')
                         .attr('stroke-width', 3)
                         .attr('opacity', 1.0)
                         .attr('class', 'ecosystem-line')
                         .attr('id', `line-${index}`);
                 });

                 // SECOND: Create central Pasar Kolaboraya node (on top of lines)
                 const centralNode = g.append('g')
                     .attr('class', 'central-node')
                     .attr('transform', `translate(${centerX}, ${centerY})`);

                 // Central circle
                 centralNode.append('circle')
                     .attr('r', centralRadius)
                     .attr('fill', 'url(#centralGradient)')
                     .attr('stroke', '#1E3A8A')
                     .attr('stroke-width', 4)
                     .attr('filter', 'url(#shadow)');

                 // Central text with better sizing and wrapping (on top of everything)
                 const centralTextSize = Math.max(centralRadius * 0.15, 12);
                 const centralText = 'PASAR KOLABORAYA';
                 const maxWidth = centralRadius * 1.8; // Leave some padding
                 const lines = wrapText(centralText, maxWidth, centralTextSize);
                 
                 // Create text elements for each line
                 lines.forEach((line, lineIndex) => {
                     centralNode.append('text')
                         .attr('text-anchor', 'middle')
                         .attr('dy', `${(lineIndex - (lines.length - 1) / 2) * 1.2}em`)
                         .attr('fill', 'white')
                         .attr('font-size', centralTextSize)
                         .attr('font-weight', 'bold')
                         .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                         .text(line);
                 });

                 // Store ecosystem groups for later role creation
                 const ecosystemGroups = [];

                 // FIRST: Draw all ecosystem circles and their content
                 ecosystems.forEach((ecosystem, index) => {
                     const angle = index * angleStep;
                     const x = centerX + Math.cos(angle) * radius;
                     const y = centerY + Math.sin(angle) * radius;

                     const ecosystemGroup = g.append('g')
                         .attr('class', 'ecosystem-group')
                         .attr('transform', `translate(${x}, ${y})`);

                     // Store for later role creation
                     ecosystemGroups.push({ group: ecosystemGroup, ecosystem: ecosystem, x: x, y: y });

                     // Ecosystem circle with gradient and shadow
                     ecosystemGroup.append('circle')
                         .attr('r', ecosystemRadius)
                         .attr('fill', 'url(#ecosystemGradient)')
                         .attr('stroke', '#047857')
                         .attr('stroke-width', 3)
                         .attr('filter', 'url(#shadow)')
                         .style('cursor', 'pointer')
                         .on('mouseover', function() {
                             d3.select(this).attr('r', ecosystemRadius + 5);
                             showEcosystemTooltip(ecosystem, event);
                             // Show role containers when ecosystem is hovered
                             g.selectAll('.role-container').style('opacity', 0);
                             g.selectAll(`.role-container-${index}`).style('opacity', 1);
                         })
                         .on('mouseout', function() {
                             d3.select(this).attr('r', ecosystemRadius);
                             hideEcosystemTooltip();
                             // Hide role containers when ecosystem is not hovered
                             g.selectAll('.role-container').style('opacity', 0);
                         })
                         .on('click', function() {
                             // Show ecosystem details modal
                             if (typeof showEcosystemDetails === 'function') {
                                 showEcosystemDetails(ecosystem);
                             }
                         });

                     // Ecosystem text with better sizing and wrapping
                     const ecosystemTextSize = Math.max(ecosystemRadius * 0.2, 10);
                     const ecosystemText = ecosystem.ecosystem.name;
                     const maxWidth = ecosystemRadius * 1.8; // Leave some padding
                     const lines = wrapText(ecosystemText, maxWidth, ecosystemTextSize);
                     
                     // Limit to maximum 3 lines
                     const displayLines = lines.slice(0, 3);
                     if (lines.length > 3) {
                         displayLines[2] = displayLines[2].substring(0, displayLines[2].length - 3) + '...';
                     }
                     
                     // Create text elements for each line
                     displayLines.forEach((line, lineIndex) => {
                         ecosystemGroup.append('text')
                             .attr('text-anchor', 'middle')
                             .attr('dy', `${(lineIndex - (displayLines.length - 1) / 2) * 1.2}em`)
                             .attr('fill', 'white')
                             .attr('font-size', ecosystemTextSize)
                             .attr('font-weight', 'bold')
                             .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                             .text(line);
                     });
                 });

                 // SECOND: Create all role containers in a separate layer (on top of ecosystem circles)
                 ecosystemGroups.forEach(({ group: ecosystemGroup, ecosystem }, index) => {
                     const roles = ecosystem.roles;
                     if (roles.length > 0) {
                         const roleAngleStep = (2 * Math.PI) / roles.length;
                         
                         // Calculate role radius - distance from ecosystem center to role centers
                         // Similar to how ecosystems are positioned around the central blue bubble
                         const roleDistance = ecosystemRadius + roleRadius + 60; // 60px gap between ecosystem and roles

                         // Create container for all role groups in separate layer
                         const roleContainer = g.append('g')
                             .attr('class', `role-container role-container-${index}`)
                             .style('opacity', 0)
                             .style('transition', 'opacity 0.3s ease');

                         roles.forEach((role, roleIndex) => {
                             const roleAngle = roleIndex * roleAngleStep;
                             const ecosystemTransform = ecosystemGroup.attr('transform');
                             const ecosystemX = parseFloat(ecosystemTransform.match(/translate\(([^,]+),([^)]+)\)/)[1]);
                             const ecosystemY = parseFloat(ecosystemTransform.match(/translate\(([^,]+),([^)]+)\)/)[2]);
                             const roleX = ecosystemX + Math.cos(roleAngle) * roleDistance;
                             const roleY = ecosystemY + Math.sin(roleAngle) * roleDistance;

                             const roleGroup = roleContainer.append('g')
                                 .attr('class', 'role-group')
                                 .attr('transform', `translate(${roleX}, ${roleY})`);

                             // Role circle with gradient and shadow
                             roleGroup.append('circle')
                                 .attr('r', roleRadius)
                                 .attr('fill', 'url(#roleGradient)')
                                 .attr('stroke', '#B45309')
                                 .attr('stroke-width', 2)
                                 .attr('filter', 'url(#shadow)')
                                 .on('mouseover', function(event) {
                                     d3.select(this).attr('r', roleRadius + 4);
                                     showRoleTooltip(role, event);
                                 })
                                 .on('mouseout', function() {
                                     d3.select(this).attr('r', roleRadius);
                                     hideRoleTooltip();
                                 });

                             // Role text with better sizing and wrapping
                             const roleTextSize = Math.max(roleRadius * 0.35, 8);
                             const roleText = role.role;
                             const maxWidth = roleRadius * 1.8; // Leave some padding
                             const lines = wrapText(roleText, maxWidth, roleTextSize);
                             
                             // Limit to maximum 2 lines for roles
                             const displayLines = lines.slice(0, 2);
                             if (lines.length > 2) {
                                 displayLines[1] = displayLines[1].substring(0, displayLines[1].length - 3) + '...';
                             }
                             
                             // Create text elements for each line
                             displayLines.forEach((line, lineIndex) => {
                                 roleGroup.append('text')
                                     .attr('text-anchor', 'middle')
                                     .attr('dy', `${(lineIndex - (displayLines.length - 1) / 2) * 1.1}em`)
                                     .attr('fill', 'white')
                                     .attr('font-size', roleTextSize)
                                     .attr('font-weight', 'bold')
                                     .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                     .text(line);
                             });

                             // Role count with better styling
                             roleGroup.append('text')
                                 .attr('text-anchor', 'middle')
                                 .attr('dy', '2.2em')
                                 .attr('fill', 'white')
                                 .attr('font-size', Math.max(roleTextSize - 2, 6))
                                 .attr('font-weight', 'bold')
                                 .attr('text-shadow', '1px 1px 2px rgba(0,0,0,0.5)')
                                 .text(role.count);
                         });
                     }
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
                     const padding = 150; // Increased padding for much more breathing room
                     const fullWidth = bounds.width + padding * 2;
                     const fullHeight = bounds.height + padding * 2;
                     const scale = Math.min(width / fullWidth, height / fullHeight, 0.7); // Further reduced scale for more space
                     const translate = [width / 2 - scale * (bounds.x + bounds.width / 2),
                         height / 2 - scale * (bounds.y + bounds.height / 2)
                     ];

                     svg.call(zoom.transform, d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale));
                 }, 100);
             }
        </script>
    @endpush
@endif
