<template>
    <b-container fluid id="v-image-clipper">
        <b-row class="justify-content-center">
            <b-col cols="12">
                <b-button v-b-modal.v-modal-avatar-image-crop>
                    Cambiar Avatar
                </b-button>

                <b-modal id="v-modal-avatar-image-crop"
                         title="Selecciona nueva imagen para tu Avatar">
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
                            <b-col cols="6">
                                <clipper-preview name="my-preview"
                                                 class="my-clipper my-clipper-rounded">
                                    <div class="placeholder" slot="placeholder">
                                        Previsualización
                                    </div>
                                </clipper-preview>
                            </b-col>

                            <b-col cols="6">
                                <clipper-preview name="my-preview"
                                                 class="my-clipper">
                                    <div class="placeholder" slot="placeholder">
                                        Previsualización
                                    </div>
                                </clipper-preview>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <clipper-fixed class="my-clipper"
                                               ref="clipper"
                                               :src="imgURL"
                                               preview="my-preview">
                                    <div class="placeholder" slot="placeholder">
                                        No hay imagen seleccionada
                                    </div>
                                </clipper-fixed>
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

    export default {
        //name: 'v-image-clipper',
        mounted() {
            console.log('Component image clipper mounted.')
        },
        data () {
            return {
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
                console.log(this.resultURL);
            },
            uploadImage: function() {
                console.log('uploadImage');
            }
        }
    }
</script>

<style lang="scss">
    #v-image-clipper {

    }
    .my-clipper {
        width: 100%;
        max-width: 700px;
    }

    .placeholder {
        text-align: center;
        padding: 20px;
        background-color: lightgray;
    }

    .my-clipper-rounded > div {
        border-radius: 50%;
    }
</style>
