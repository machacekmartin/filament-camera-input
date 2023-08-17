@php
    $color = $getColor();
@endphp

<div x-data="{
    stream: null,
    image: null,
    mirrored: false,
    loading: false,
    async startStream() {
        this.loading = true;
        this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
        $refs.video.srcObject = this.stream;
        this.loading = false;
    },
    stopStream(){
        $refs.video.pause();
        $refs.video.removeAttribute('src');
        $refs.video.load();

        this.stream?.getTracks().forEach(track => track.stop());
        this.stream = null;
    },
    moveRectangle(event) {
        let rect = $refs.wrapper.getBoundingClientRect();

        let coords = {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top
        };

        $refs.rectangle.style.left = coords.x - ($refs.rectangle.offsetWidth / 2) + 'px';
        $refs.rectangle.style.top = coords.y +- ($refs.rectangle.offsetHeight / 2) + 'px';
    },
    activate() {
        $refs.wrapper.addEventListener('mousemove', this.moveRectangle);
    },
    release() {
        $refs.wrapper.removeEventListener('mousemove', this.moveRectangle);
    },
    capture() {
        const canvas = document.createElement('canvas');
        canvas.width = $refs.video.videoWidth;
        canvas.height = $refs.video.videoHeight;
        const ctx = canvas.getContext('2d');

        if (this.mirrored) {
            ctx.scale(-1, 1);
            ctx.drawImage( $refs.video, 0, 0, -canvas.width, canvas.height);
        } else {
            ctx.drawImage( $refs.video, 0, 0, canvas.width, canvas.height);
        }

        canvas.toBlob((blob) => {
            const file = new File([blob], 'captured_frame.png', { type: 'image/png' })
            this.image = URL.createObjectURL(file)
        }, 'image/png');
    }
}">
    <p
        {{
            $attributes->class([
                match ($color) {
                    default => 'text-primary-600 dark:text-primary-400',
                },
            ])
        }}
    >
        {{ $getLabel() }}
    </p>

    <div
        role="button"
        x-on:click="startStream"
    >
        Start stream
    </div>
    <div
        role="button"
        x-on:click="stopStream"
    >
        Stop stream
    </div>
    <div
        role="button"
        x-on:click="mirrored = !mirrored"
    >
        Rotate
    </div>
    <div
        role="button"
        x-on:click="capture"
    >
        Capture Frame
    </div>
    <div
        role="button"
        x-on:click="image = null"
    >
        Clear Frame
    </div>

    <div x-bind:class="{ 'bg-white': loading }" style="position: relative; max-width: 600px; height: 400px; border-radius: .45rem; overflow: hidden; border: solid 1px rgba(255,255,255,.2)">
        <video
            x-ref="video"
            x-bind:style="{ transform: mirrored ? 'scaleX(-1)' : 'none' }"
            style="width: 100%; height: 100%; background: rgba(255, 255, 255, 0.05)"
            autoplay
        ></video>
        <div x-ref="wrapper" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; overflow: hidden;">
            <template x-if="image !== null">
                <div
                    x-ref="rectangle"
                    x-on:mousedown.self="activate"
                    x-on:mouseup.self="release"
                    style="width: 100px; height: 100px; border-radius: .8rem; position: absolute; top: 0; left: 0; border: white 2px dashed; cursor: move; pointer-events: all; position: absolute;">
                </div>
            </template>

            <template x-if="image !== null">
                <img :src="image" style="pointer-events: none; user-select: none; height: 100%; width: 100%; object-fit: contain">
            </template>
        </div>
    </div>
</div>
