<template>
    <div>
        <h1>Super Editor by fryntiz</h1>
        <div class="imageEditorApp">
            <editor
                :initialValue="editorText"
                :options="options"
                :height="height"
                :previewStyle="previewStyle"
            />
        </div>
    </div>
</template>

<script>

    import 'codemirror/lib/codemirror.css';
    import '@toast-ui/editor/dist/toastui-editor.css';

    //import {Editor} '@toast-ui/editor';
    import {Editor} from '@toast-ui/vue-editor';

    import chart from '@toast-ui/editor-plugin-chart';

    import '@toast-ui/editor-plugin-color-syntax'
    import '@toast-ui/editor-plugin-uml'
    import '@toast-ui/editor-plugin-code-syntax-highlight'
    import '@toast-ui/editor-plugin-table-merged-cell'
    import '@toast-ui/editor'



    //import ToastuiEditor from '@toast-ui/editor';

    //import {ImageEditor} from '@toast-ui/vue-edit';

    //import ToastuiEditorViewer from '@toast-ui/editor/dist/toastui-editor-viewer';


    // Configuración para las gráficas "chart"
    const chartOptions = {
        minWidth: 100,
        maxWidth: 400,
        minHeight: 100,
        maxHeight: 300
    };



    export default {
        components: {
            'editor': Editor
        },
        data() {
            return {
                useDefaultUI: true,
                editorText: `
# Lorem Ipsum

---

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

---

- Element 1
- Element 2
- Element 3

---

- [ ] Checklist 1
- [x] Checklist 2
- [ ] Checklist 3


## Ejemplo de gráfica.

\`\`\`chart
,category1,category2
Jan,21,23
Feb,31,17

type: column
title: Monthly Revenue
x.title: Amount
y.title: Month
y.min: 1
y.max: 40
y.suffix: $
\`\`\`
`,
                options: {
                    plugins: [[chart, chartOptions]],


                    // Ocultar el cambio de modo para markdown/WYSIWYG.
                    hideModeSwitch: false,

                    // Editor al iniciar (wysiwyg|markdown)
                    initialEditType: "markdown"
                },

                // Altura.
                height: "700px",

                // Orientación para previsualizar.
                previewStyle: 'vertical'
            };
        },
        methods: {

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
