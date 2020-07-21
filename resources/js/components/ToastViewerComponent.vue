<template>
    <viewer
        :initialValue="viewerText"
        :height="height"
        @load="onEditorLoad"
        @focus="onEditorFocus"
        @blur="onEditorBlur"
        @change="onEditorChange"
        @stateChange="onEditorStateChange"
    />
</template>

<script>
    import '@toast-ui/editor/dist/toastui-editor-viewer.css';

    import { Viewer } from '@toast-ui/vue-editor';

    export default {
        components: {
            viewer: Viewer
        },
        props: [
            'content'
        ],
        data() {
            return {
                height: '500px',
                //viewerText: '# This is Viewer.\n Hello World.'
                viewerText: this.content
            };
        },
        methods: {
            onEditorLoad() {
                // implement your code
            },
            onEditorFocus() {
                // implement your code
            },
            onEditorBlur() {
                // implement your code
            },
            onEditorChange() {
                // implement your code
            },
            onEditorStateChange() {
                // implement your code
            },
        }
    };
</script>
