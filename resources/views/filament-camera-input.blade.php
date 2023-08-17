@php
    $color = $getColor();
@endphp

<div x-data="{
    stream: null,
    image: null,
    mirrored: false,
    async startStream() {
        this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
        $refs.video.srcObject = this.stream;
    },
    stopStream(){
        $refs.video.pause();
        $refs.video.removeAttribute('src');
        $refs.video.load();

        this.stream?.getTracks().forEach(track => track.stop());
        this.stream = null;
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

    <div>
        <div x-on:click="mirrored = !mirrored">Rotate</div>
        <video
            x-ref="video"
            x-bind:style="{ transform: mirrored ? 'scaleX(-1)' : 'none' }"
            autoplay
        ></video>
        <div x-on:click="capture">Capture Frame</div>
    </div>
    <img :src="image">
</div>
