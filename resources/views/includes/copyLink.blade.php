<script>
    // document.addEventListener('keydown', (e) => Livewire.emit('handleKeypress', e.code));
</script>

<script>
    const links = document.querySelectorAll('.link-copy');

    links.forEach(function (link) {
        initLink(link);
    })

    function initLink(link) {
        link.setAttribute('x-data-original-label', link.innerHTML);

        link.addEventListener('click', function () {
            removeCopiedLinkStyles();

            const url = link.getAttribute('x-data-url');

            try {
                navigator.clipboard.writeText(url);
            } catch (e) {
            }

            link.classList.add('font-bold', 'text-green-600');

            const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M18 5.25a2.25 2.25 0 00-2.012-2.238A2.25 2.25 0 0013.75 1h-1.5a2.25 2.25 0 00-2.238 2.012c-.875.092-1.6.686-1.884 1.488H11A2.5 2.5 0 0113.5 7v7h2.25A2.25 2.25 0 0018 11.75v-6.5zM12.25 2.5a.75.75 0 00-.75.75v.25h3v-.25a.75.75 0 00-.75-.75h-1.5z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 6a1 1 0 00-1 1v10a1 1 0 001 1h8a1 1 0 001-1V7a1 1 0 00-1-1H3zm6.874 4.166a.75.75 0 10-1.248-.832l-2.493 3.739-.853-.853a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.154-.114l3-4.5z" clip-rule="evenodd" />
            </svg>`;

            link.innerHTML = `${svg} <span class="ml-1">Copied!</span>`;
        })
    }

    function removeCopiedLinkStyles() {
        links.forEach(function (link) {
            link.classList.remove('font-bold', 'text-green-600');
            link.innerHTML = link.getAttribute('x-data-original-label');
        })
    }
</script>
