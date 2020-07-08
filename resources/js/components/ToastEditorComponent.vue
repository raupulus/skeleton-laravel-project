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

    // Añadir botones personalizados:
    //https://nhn.github.io/tui.editor/latest/tutorial-example19-customizing-toolbar-buttons


    import 'codemirror/lib/codemirror.css';

    // https://www.npmjs.com/package/@toast-ui/vue-editor
    import '@toast-ui/editor/dist/toastui-editor.css';

    //import {Editor} '@toast-ui/editor';
    import {Editor} from '@toast-ui/vue-editor';

    //https://github.com/nhn/tui.editor/tree/master/plugins/chart
    import chart from '@toast-ui/editor-plugin-chart';

    //https://github.com/nhn/tui.editor/tree/master/plugins/color-syntax
    import colorSyntax         from '@toast-ui/editor-plugin-color-syntax';

    //https://github.com/nhn/tui.editor/tree/master/plugins/code-syntax-highlight
    import 'highlight.js/styles/github.css';
    import codeSyntaxHighlight
                               from '@toast-ui/editor-plugin-code-syntax-highlight';
    import hljs                from 'highlight.js';

    //https://github.com/nhn/tui.editor/tree/master/plugins/table-merged-cell
    import tableMergedCell from '@toast-ui/editor-plugin-table-merged-cell';


    //https://github.com/nhn/tui.editor/tree/master/plugins/uml
    // No lo uso, no iba demasiado bien a veces, revisar depurador al usarlo
    //import uml from '@toast-ui/editor-plugin-uml';


    // Importo todos los idiomas que usa la aplicación
    //https://github.com/nhn/tui.editor/blob/master/apps/editor/docs/i18n.md
    import '@toast-ui/editor/dist/i18n/es-es';


    // Configuración para las gráficas "chart"
    const chartOptions = {
        minWidth:100,
        maxWidth:400,
        minHeight:100,
        maxHeight:300
    };

    // Configuración para el plugin de dar color.
    const colorSyntaxOptions = {
        preset:['#181818', '#292929', '#393939'],
        useCustomSyntax:true
    };

    // Configuración para el plugin uml
    /*
     const umlOptions = {
     rendererURL: 'http://www.plantuml.com/plantuml/png/'
     };
     */

    /*
    function youtubePlugin() {
        console.log(Editor);
        console.log(Editor.codeBlockManager);

        Editor.codeBlockManager.setReplacer('youtube',
            function(youtubeId) {
                // Indentify multiple code blocks
                const wrapperId = `yt${Math.random()
                    .toString(36)
                    .substr(2, 10)}`;

                // Avoid sanitizing iframe tag
                setTimeout(renderYoutube.bind(null, wrapperId, youtubeId), 0);

                return `<div id="${wrapperId}"></div>`;
            });
    }

    function renderYoutube(wrapperId, youtubeId) {
        const el = document.querySelector(`#${wrapperId}`);

        el.innerHTML = `<iframe width="420" height="315" src="https://www.youtube.com/embed/${youtubeId}"></iframe>`;
    }

     */

    export default {
        components:{
            'editor':Editor
        },
        mounted() {
            //console.log('Component image clipper mounted.')
        },
        data() {
            return {
                useDefaultUI:true,
                editorText:`
# Lorem Ipsum

---

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

---

- Element 1
- Element 2
- Element 3

---

## Ejemplo de código javascript

\`\`\`javascript
console.log('hola')
\`\`\`

---

## Ejemplo de checklist

- [ ] Checklist 1
- [x] Checklist 2
- [ ] Checklist 3

---

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

---

### Ejemplo de tabla combinada

|@cols=2:Title|
|---|---|
|cell1|cell2|

---

### Ejemplo de gráfico uml

\`\`\`uml
partition Conductor {
  (*) --> \"Climbs on Platform\"
  --> === S1 ===
  --> Bows
}

partition Audience #LightSkyBlue {
  === S1 === --> Applauds
}

partition Conductor {
  Bows --> === S2 ===
  --> WavesArmes
  Applauds --> === S2 ===
}

partition Orchestra #CCCCEE {
  WavesArmes --> Introduction
  --> \"Play music\"
}
\`\`\`

---

## Vídeo de youtube

\`\`\`youtube
XyenY12fzAk
\`\`\`

`,
                options:{
                    language:'es-ES',

                    plugins:[
                        [chart, chartOptions],
                        [colorSyntax, colorSyntaxOptions],
                        [codeSyntaxHighlight, hljs],
                        [tableMergedCell],
                        //[uml, umlOptions],
                        //[youtubePlugin],
                    ],


                    // Ocultar el cambio de modo para markdown/WYSIWYG.
                    hideModeSwitch:false,

                    // Editor al iniciar (wysiwyg|markdown)
                    initialEditType:"markdown"
                },

                // Altura.
                height:"700px",

                // Orientación para previsualizar.
                previewStyle:'vertical'
            };
        },
        methods:{}
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
