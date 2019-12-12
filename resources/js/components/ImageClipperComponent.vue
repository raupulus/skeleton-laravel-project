<template>
    <div id="v-image-clipper" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Upload Image</h3>
                    </div>

                    <div class="card-body">
                        <h4>Image upload</h4>
                        <br />
                        Mensaje: {{msg}}

                        <br />

                        <button>
                            <clipper-upload v-model="imgURL">upload image</clipper-upload>
                        </button>

                        <button @click="getResult">
                            clip image
                        </button>

                        <clipper-fixed class="my-clipper"
                                       ref="clipper"
                                       :src="imgURL"
                                       preview="my-preview">
                            <div class="placeholder" slot="placeholder">No image</div>
                        </clipper-fixed>

                        <div>
                            <clipper-range :min="rangeMin"
                                           :max="rangeMax"></clipper-range>
                        </div>

                        <div>
                            <div>preview:</div>
                            <clipper-preview name="my-preview" class="my-clipper">
                                <div class="placeholder" slot="placeholder">
                                    preview area
                                </div>
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

    import 'vuejs-clipper';


    export default {
        //name: 'v-image-clipper',
        mounted() {
            console.log('Component image clipper mounted.')
        },
        data () {
            return {
                msg: 'Mensaje de prueba',
                imgURL: '',
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
