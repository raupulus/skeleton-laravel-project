<template>
    <b-container fluid id="v-image-clipper">
        <b-row class="justify-content-center">
            <b-col cols="12">
                <b-button v-b-modal.v-modal-avatar-image-crop @click="show=true">
                    Cambiar Avatar
                </b-button>

                <b-modal id="v-modal-avatar-image-crop"
                         title="Selecciona nueva imagen para tu Avatar"
                         size="xl"
                         v-model="show"
                         centered>
                    <!-- Step 1 -->
                    <b-container fluid>
                        <!-- Mensaje de ayuda -->
                        <b-row>
                            <b-col cols="12"
                                   class="mt-3 mb-3 p-3 bg-primary text-warning font-weight-bold">
                                {{msgStep1}}
                            </b-col>
                        </b-row>

                        <!-- Previsualización de imágen actual -->
                        <b-row>
                            <b-col cols="6">
                                <b-img rounded="circle"
                                       fluid
                                       :src="imgOriginal"
                                       alt="Avatar Original redondeado"></b-img>
                            </b-col>

                            <b-col cols="6">
                                <b-img rounded
                                       fluid
                                       :src="imgOriginal"
                                       alt="Avatar original cuadrado"></b-img>
                            </b-col>
                        </b-row>

                        <!-- Botón para seleccionar imagen -->
                        <b-row class="mt-3 mb-3">
                            <b-col cols="12" class="text-center">
                                <b-button>
                                    <clipper-upload v-model="imgURL">
                                        Seleccionar imagen
                                    </clipper-upload>
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-container>

                    <!-- Step 2 -->
                    <b-container>
                        <!-- Mensaje de ayuda -->
                        <b-row>
                            <b-col cols="12"
                                   class="mt-3 mb-3 p-3 bg-primary text-warning font-weight-bold">
                                {{msgStep2}}
                            </b-col>
                        </b-row>

                        <!-- Previsualización de imágen nueva -->
                        <b-row>
                            <b-col cols="6" cols-sm="12">
                                <clipper-fixed class="my-clipper"
                                               ref="clipper"
                                               :src="imgURL"
                                               preview="my-preview">
                                    <div class="placeholder" slot="placeholder">
                                        No hay imagen seleccionada
                                    </div>
                                </clipper-fixed>
                            </b-col>

                            <b-col cols="6" cols-sm="12">
                                <b-row>
                                    <b-col cols="12"
                                           class="box-my-clipper-preview">
                                        <clipper-preview name="my-preview"
                                                         class="my-clipper my-clipper-rounded">
                                            <div class="placeholder" slot="placeholder">
                                                Previsualización
                                            </div>
                                        </clipper-preview>
                                    </b-col>

                                    <b-col cols="12"
                                           class="box-my-clipper-preview">
                                        <clipper-preview name="my-preview"
                                                         class="my-clipper">
                                            <div class="placeholder" slot="placeholder">
                                                Previsualización
                                            </div>
                                        </clipper-preview>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>

                        <b-row class="mt-3 mb-3">
                            <b-col class="text-center">
                                <b-button variant="danger">
                                    Atrás
                                </b-button>
                            </b-col>

                            <b-col class="text-center">
                                <b-button variant="success" @click="getResult">
                                    Guardar Imagen
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-container>

                    <template v-slot:modal-footer>
                        <div class="w-100">
                            <b-button
                                variant="warning"
                                size="sm"
                                class="float-right"
                                @click="show=false"
                            >
                                Cerrar
                            </b-button>
                        </div>
                    </template>
                </b-modal>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    //https://www.npmjs.com/package/vuejs-clipper
    //https://timtnleeproject.github.io/vuejs-clipper/#/examples/quick-start
    //https://timtnleeproject.github.io/vuejs-clipper/#/examples/profile-photo

    import 'vuejs-clipper';
    import axios from 'axios';
    import VueAxios from "vue-axios";

    export default {
        //name: 'v-image-clipper',
        mounted() {
            console.log('Component image clipper mounted.')
        },
        data () {
            return {
                show: false,
                msgStep1: 'Así se ve tu imagen actual, puedes subir una nueva.',
                msgStep2:
                    'Mueve la imagen para centrarla, puedes hacer scroll ' +
                    'para aumentar o disminuir su tamaño.',
                imgURL: '',
                imgOriginal: 'https://picsum.photos/250/250/?image=54',
                resultURL: '',
                originalName: '',
                rangeMin: 0,
                rangeMax: 10
            }
        },
        methods: {
            getResult: function () {
                console.log('getResult');
                const canvas = this.$refs.clipper.clip();//call component's clip method
                this.resultURL = canvas.toDataURL("image/jpeg", 1);//canvas->image
                //console.log(this.resultURL);
                this.uploadImage();
            },
            uploadImage: function() {
                console.log('uploadImage');
                axios.post(
                    '/panel/user/ajax/avatar/upload',
                    {
                        image: this.resultURL,
                        user_id: 1
                    }
                );

                /*
                axios.get("https://jsonplaceholder.typicode.com/todos/")
                    .then(response => {
                        this.todosList = [...response.data].slice(0, 10)
                    });

                */
            }
        }
    }
</script>

<style lang="scss">
    #v-image-clipper {

    }
    .my-clipper {
        width: 100%;
        max-width: 300px;
        border: 3px solid #3a3a3a;
    }

    .placeholder {
        text-align: center;
        padding: 20px;
        background-color: lightgray;
    }

    .box-my-clipper-preview {
        margin: 10px;
    }

    .my-clipper-rounded > div {
        border-radius: 50%;
    }
</style>
