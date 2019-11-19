<template>
    <div id="v-image-clipper" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Título test</div>

                    <div class="card-body">
                        Subtítulo test
                        <br />
                        Mensaje: {{msg}}

                        <br />
                        <button>
                            <clipper-upload v-model="imgURL">upload image</clipper-upload>
                        </button>
                        <button @click="getResult">clip image</button>
                        <clipper-basic class="my-clipper" ref="clipper" :src="imgURL" preview="my-preview">
                            <div class="placeholder" slot="placeholder">No image</div>
                        </clipper-basic>
                        <div>
                            <div>preview:</div>
                            <clipper-preview name="my-preview" class="my-clipper">
                                <div class="placeholder" slot="placeholder">preview area</div>
                            </clipper-preview>
                        </div>
                        <div>
                            <div>result:</div>
                            <img class="result" :src="resultURL" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //https://www.npmjs.com/package/vuejs-clipper
    //https://timtnleeproject.github.io/vuejs-clipper/#/examples/quick-start
    //https://timtnleeproject.github.io/vuejs-clipper/#/examples/profile-photo

    import VuejsClipper from 'vuejs-clipper';
    Vue.use(VuejsClipper);

    export default {
        //name: 'v-image-clipper',
        mounted() {
            console.log('Component test mounted.')
        },
        data () {
            return {
                msg: 'Mensaje de prueba',
                imgURL: '',
                resultURL: ''
            }
        },
        methods: {
            getResult: function () {
                const canvas = this.$refs.clipper.clip();//call component's clip method
                this.resultURL = canvas.toDataURL("image/jpeg", 1);//canvas->image
            }
        }
    }
</script>

<style lang="scss">
    .my-clipper {
        width: 100%;
        max-width: 700px;
    }

    .placeholder {
        text-align: center;
        padding: 20px;
        background-color: lightgray;
    }
</style>
