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
            link.classList.remove('font-bold', 'text-green-600');
            link.classList.add('underline');
            link.innerHTML = link.getAttribute('x-data-original-label');
        })
    }
</script>
