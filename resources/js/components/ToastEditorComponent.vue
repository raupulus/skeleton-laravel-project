<template>
    <div>
        <h1>Super Editor by fryntiz</h1>
        <div class="imageEditorApp">
            <template>
                <editor />
            </template>
        </div>
    </div>
</template>

<script>

    import 'codemirror/lib/codemirror.css';
    import '@toast-ui/editor/dist/toastui-editor.css';

    //import {Editor} '@toast-ui/editor';
    import {Editor} from '@toast-ui/vue-editor';

    import '@toast-ui/editor-plugin-chart'
    import '@toast-ui/editor-plugin-color-syntax'
    import '@toast-ui/editor-plugin-uml'
    import '@toast-ui/editor-plugin-code-syntax-highlight'
    import '@toast-ui/editor-plugin-table-merged-cell'
    import '@toast-ui/editor'



    //import ToastuiEditor from '@toast-ui/editor';

    //import {ImageEditor} from '@toast-ui/vue-edit';

    //import ToastuiEditorViewer from '@toast-ui/editor/dist/toastui-editor-viewer';

    export default {
        components: {
            'editor': Editor
        },
        data() {
            return {
                useDefaultUI: true,
                options: {
                    cssMaxWidth: 500,
                    cssMaxHeight: 1000
                }
                /*
                options: {
                    includeUI: {
                        loadImage: {
                            path: sampleImage,
                            name: 'sampleImage2'
                        },
                        initMenu: 'filter'
                    },
                    cssMaxWidth: 700,
                    cssMaxHeight: 500
                }

                 */
            };
        },
        methods: {
            onAddText(res) {
                /* eslint-disable no-console */
                console.group('addText');
                console.log('Client Position : ', res.clientPosition);
                console.log('Origin Position : ', res.originPosition);
                console.groupEnd();
                /* eslint-enable no-console */
            },
            onObjectMoved(res) {
                /* eslint-disable no-console */
                console.group('objectMoved');
                console.log('Left : ', res.left);
                console.log('Top : ', res.top);
                console.groupEnd();
                /* eslint-enable no-console */
            }
        }
    };
</script>

<style scoped>
    /*
    .imageEditorApp {
        width: 1000px;
        height: 800px;
    }

     */
</style>
