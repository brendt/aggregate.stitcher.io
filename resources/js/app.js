const ajaxButtons = document.querySelectorAll('.ajax-button');

for (let button of ajaxButtons) {
    button.addEventListener('click', onAjaxButtonClick.bind(button));
}

function onAjaxButtonClick(e) {
    e.stopPropagation();
    e.preventDefault();

    const form = this.parentElement;
    const action = form.action;
    const token = form.querySelector('input[name=_token]').value;

    let request = new XMLHttpRequest();

    request.open('POST', action, true);

    request.onload = function() {
        if (request.status < 200 || request.status >= 400) {
            // TODO
            return;
        }

        const data = JSON.parse(request.responseText);

        const callback = actionButtonHandlers[this.getAttribute('data-done')];

        callback(data);
    }.bind(this);

    request.onerror = function() {
        // TODO
    };

    request.setRequestHeader('content-type', 'application/json');
    request.setRequestHeader('accept', 'application/json');

    request.send(
        JSON.stringify({
            _token: token,
        })
    );
}

const actionButtonHandlers = {
    updateVote(data) {
        const uuid = data.post_uuid;
        const postVote = document.querySelector(`#post-vote-${uuid}`);
        const voteCounters = postVote.querySelectorAll('.vote-count');

        if (data.voted_for) {
            postVote.classList.add('voted-for');
        } else {
            postVote.classList.remove('voted-for');
        }

        for (let voteCounter of voteCounters) {
            voteCounter.innerHTML = data.vote_count;
            voteCounter.setAttribute('data-vote-count', data.vote_count);
        }
    },
};

const menu = document.querySelector('.menu');
const menuToggle = document.querySelector('.menu-toggle');

menuToggle.addEventListener('click', function() {
    menu.classList.toggle('hidden');
});
