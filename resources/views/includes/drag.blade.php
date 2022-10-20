<style>
    :root {
        --drag-background-color: #fff;
    }

    .left {
        --drag-background-color: rgb(237, 204, 204);
        --final-drag-background-color: rgb(243, 162, 162);
        --final-position: -200%;
    }

    .right {
        --drag-background-color: rgb(200, 235, 201);
        --final-drag-background-color: rgb(145, 239, 149);
        --final-position: 200%;
    }

    .drag-container {
        position: relative;
        height: auto;
        max-height: 1000px;
        overflow-x: hidden;
    }

    /* 0 reset */
    .drag {
        background-color: var(--drag-background-color);
        width: 100%;
        position: relative;
        height: auto;
        left: 0;
        top: 0;
    }

    /* 1 */
    .dragging {
        background-color: var(--drag-background-color);
    }

    /* 2 */
    .border-reached {
        background-color: var(--final-drag-background-color);
    }

    /* 3 */
    .drag-container.dragged {
        max-height: 0;
        transition: all 0.3s 0s ease-in;
        background-color: var(--final-drag-background-color);
    }

    .drag-container.dragged .drag {
        left: var(--final-position);
        transition: all 0.4s 0s ease-in;
    }
</style>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    class Drag
    {
        element;
        event;

        constructor(element, event) {
            this.element = element;
            this.event = event;
        }

        get deltaX() {
            // TODO: refactor to x-drag-start-x
            const startX = this.element.getAttribute('x-drag-start');
            const currentPosX = this.event.changedTouches[0].pageX;

            return currentPosX - startX;
        }

        get deltaY() {
            const startY = this.element.getAttribute('x-drag-start-y');
            const currentPosY = this.event.changedTouches[0].pageY;

            return currentPosY - startY;
        }

        get borderReached() {
            return this.element.classList.contains('border-reached');
        }

        isDraggingVertical() {
            if (this.element.hasAttribute('x-dragging-horizontal')) {
                return false;
            }

            return Math.abs(this.deltaY) > 10
                || this.element.hasAttribute('x-dragging-vertical');
        }

        isDraggingHorizontal() {
            if (this.element.hasAttribute('x-dragging-vertical')) {
                return false;
            }

            return Math.abs(this.deltaX) > 10
                || this.element.hasAttribute('x-dragging-horizontal');
        }

        markDraggingHorizontal() {
            this.element.setAttribute('x-dragging-horizontal', 'true');
        }

        markDraggingVertical() {
            this.element.setAttribute('x-dragging-vertical', 'true');
        }

        isAlreadyDragging() {
            return this.isDraggingVertical() || this.isDraggingHorizontal();
        }

        determineDragDirection() {
            if (this.isDraggingHorizontal()) {
                this.markDraggingHorizontal();

                return 'horizontal';
            } else if (this.isDraggingVertical()) {
                this.markDraggingVertical();

                return 'vertical';
            } else {
                return null;
            }
        }

        setPosition() {
            this.element.style.left = `${this.deltaX}px`;
        }

        setDirection() {
            this.element.classList.remove('left');
            this.element.classList.remove('right');
            this.element.classList.add(this.deltaX > 0 ? 'right' : 'left');
        }

        detectBorder() {
            const border = this.element.offsetWidth / 4;

            if (Math.abs(this.deltaX) > border) {
                // Border reached
                this.element.classList.add('border-reached');
            } else {
                // Border not reached
                this.element.classList.remove('border-reached');
            }
        }

        reset() {
            this.element.classList.remove('left');
            this.element.classList.remove('right');
            this.element.classList.remove('border-reached');
            this.element.classList.remove('dragging');
            this.element.style.left = 0;
            this.element.removeAttribute('x-dragging-horizontal');
            this.element.removeAttribute('x-dragging-vertical');
        }

        handleDragStart() {
            this.element.setAttribute('x-drag-start', this.event.changedTouches[0].pageX);
            this.element.setAttribute('x-drag-start-y', this.event.changedTouches[0].pageY);
        }

        handleDragMove() {
            if (this.determineDragDirection() === 'vertical') {
                return;
            }

            if (Math.abs(this.deltaX) < 10) {
                return;
            }

            if (this.event.cancelable) {
                this.event.preventDefault();
            }

            this.event.stopPropagation();

            this.setDirection();
            this.setPosition();
            this.detectBorder();
        }

        handleDragEnd() {
            this.element.removeAttribute('x-dragging-vertical');

            if (!this.borderReached) {
                this.reset();

                return;
            }

            const container = this.element.parentElement;
            const isLeft = this.element.classList.contains('left');
            const action = isLeft ? 'deny' : 'save';

            this.element.classList.add('dragged');
            this.element.style.left = null;
            container.classList.add('dragged');
            container.classList.add(isLeft ? 'left' : 'right');

            navigator.vibrate(200);
            
            fetch(this.element.getAttribute(`x-${action}-url`), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                }
            });

            const counterId = this.element.getAttribute(`x-counter-id`);

            const countElement = document.querySelector(`#${counterId}`);
            const count = parseInt(countElement.innerHTML);

            countElement.innerHTML = count - 1;
        }
    }

    const init = function (element) {
        element.addEventListener('touchstart', (event) => {
            const drag = new Drag(element, event);

            drag.handleDragStart();
        });

        element.addEventListener('touchmove', (event) => {
            const drag = new Drag(element, event);

            drag.handleDragMove();
        });

        element.addEventListener('touchend', (event) => {
            const drag = new Drag(element, event);

            drag.handleDragEnd();
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.drag').forEach((element) => init(element));
    });
</script>
