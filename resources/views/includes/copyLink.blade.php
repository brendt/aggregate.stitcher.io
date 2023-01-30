<script>
    const links = document.querySelectorAll('.link-copy');

    links.forEach(function (link) {
        initLink(link);
    })

    function initLink(link) {
        link.addEventListener('click', function () {
            removeCopiedLinkStyles();

            const url = link.getAttribute('x-data-url');

            try {
                navigator.clipboard.writeText(url);
            } catch (e) {
            }

            link.classList.add('font-bold', 'text-green-600');
            link.classList.remove('underline');


            const hideUrl = link.getAttribute('x-data-hide-url');

            if (hideUrl) {
                link.innerHTML = 'Copied!';
            } else {
                link.innerHTML = `Copied! ${url}`;
            }
        })
    }

    function removeCopiedLinkStyles() {
        links.forEach(function (link) {
            const hideUrl = link.getAttribute('x-data-hide-url');
            const url = link.getAttribute('x-data-url');
            link.classList.remove('font-bold', 'text-green-600');
            link.classList.add('underline');

            if (hideUrl) {
                link.innerHTML = 'Copy';
            } else {
                link.innerHTML = url;
            }
        })
    }
</script>
