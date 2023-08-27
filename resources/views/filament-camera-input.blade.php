<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-actions="$getHintActions()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :hint-icon-tooltip="$getHintIconTooltip()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
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
            const rect = $refs.wrapper.getBoundingClientRect();

            $refs.rectangle.style.left = event.clientX - rect.left - ($refs.rectangle.offsetWidth / 2) + 'px';
            $refs.rectangle.style.top = event.clientY - rect.top +- ($refs.rectangle.offsetHeight / 2) + 'px';
        },
        activate() {
            $refs.wrapper.addEventListener('mousemove', this.moveRectangle);
        },
        release() {
            $refs.wrapper.removeEventListener('mousemove', this.moveRectangle);
        },
        capture() {
            $refs.canvas.width = $refs.rectangle.offsetWidth;
            $refs.canvas.height = $refs.rectangle.offsetHeight;

            const scaleX = $refs.video.videoWidth / $refs.video.offsetWidth;
            const scaleY = $refs.video.videoHeight / $refs.video.offsetHeight;

            $refs.canvas.getContext('2d').drawImage($refs.video,
                ($refs.rectangle.offsetLeft - $refs.video.offsetLeft) * scaleX,
                ($refs.rectangle.offsetTop - $refs.video.offsetTop) * scaleY,
                $refs.rectangle.offsetWidth * scaleX, $refs.rectangle.offsetHeight * scaleY,
                0, 0,
                $refs.canvas.width, $refs.canvas.height
            );

            $refs.canvas.toBlob((blob) => {
                const file = new File([blob], 'captured_frame.png', { type: 'image/png' })
                this.image = URL.createObjectURL(file)

                @this.upload(`{{ $getStatePath() }}`, file)
            }, 'image/png');
        },
    }">
        <p>
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
            Capture Cropped Frame
        </div>
        <div
            role="button"
            x-on:click="image = null"
        >
            Clear Frame
        </div>

        <div x-bind:class="{ 'bg-white': loading }" style="position: relative; max-width: 100%; border-radius: .45rem; overflow: hidden; border: solid 1px rgba(255,255,255,.2)">
            <video
                x-ref="video"
                x-bind:style="{ transform: mirrored ? 'scaleX(-1)' : 'none' }"
                style="width: 100%; height: 100%; background: rgba(255, 255, 255, 0.05)"
                autoplay
            ></video>
            <div x-ref="wrapper" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; overflow: hidden; display: flex; align-items: center; justify-content: center">
                <div
                    x-ref="rectangle"
                    x-on:mousedown.self="activate"
                    x-on:mouseup.self="release"
                    style="height: 80%; box-shadow: rgba(0,0,0,.9) 0px 0px 10px 100vw; border-radius: 0; aspect-ratio: 1/1; border: rgba(255,255,255,.2) 2px dashed; position: absolute; cursor: move; pointer-events: all;">
                </div>

                <template x-if="image !== null">
                    <img x-bind:src="image" style="pointer-events: none; user-select: none; height: 100%; width: 100%; object-fit: contain; z-index: 50" x-ref="image">
                </template>
            </div>
        </div>
        <canvas x-ref="canvas" style="display: none"></canvas>
    </div>
</x-dynamic-component>
