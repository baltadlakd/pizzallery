<template>
  <div id="upc">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!--Generar contraseña-->
                <div class="card card-default">
                    <div class="card-header">Generar contraseña</div>

                    <div class="card-body">
                        <div class="container">
                          <div class="form">
                            <form @keydown="clearError($event.target.name)">

                              <fieldset class="form-group">
                                <input name="password" v-model="pass.password" type="text" class="form-control" id="password" placeholder="Nueva contraseña">
                                <br>
                              </fieldset>
                              <fieldset class="form-group">
                                <input name="password" v-model="pass.password_confirmation" type="text" class="form-control" id="password_confirmation" placeholder="Repetir contraseña">
                              </fieldset>
                              <small class="text text-danger" v-if="isAnyError()" > {{ errors.errors.password[0] }}</small>
                              <br>
                              <div class="dropdown-divider"> </div>
                              <br>
                              <button type="submit" class="btn btn-primary" v-on:click.prevent="createPassword()">Aceptar</button>
                            </form>
                            <br>
                            <div v-if="passwordMismatch" class="alert alert-danger" role="alert">
                              <strong>Advertencia! </strong> Las contraseñas no coinciden <a href="#" class="alert-link">, intenta de nuevo</a>.
                            </div>
                            <div class="alert alert-dismissible fade show" role="alert"
                                 v-if="notify.status" :class="[notify.status ? 'alert alert-success' : 'alert alert-danger']">
                              <strong>{{notify.start}} </strong> {{notify.message}}.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                          </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
  </div>
</template>

<script>


    export default {
        mounted() {
            console.log('VUE_createPassword.')
        },
        data(){
          return{
              pass:{
                password:'',
                password_confirmation:''
              },
              passwordMismatch: false,
              notify:{
                start:'',
                message:'',
                status:false,
              },
              errors:{},
          }
        },
        props: [
          'vuser',
          'vroute',
        ],
        methods:{
          isAnyError(){
            if(this.errors.errors){
              return true;
            }
          },
          recordError(errors){
            this.errors = errors;
          },
          clearError(error){
            if(this.isAnyError()){
              console.log("clear" + error);
              delete this.errors.errors[error][0];
            }
          },
          createPassword(){
            if( this.pass.password === this.pass.password_confirmation){
                axios.post(this.vroute,this.pass)
                  .then( response => {
                    this.pass = {};
                    this.errors = {};
                    this.notify = response.data;
                    console.log(response);

                  })
                  .catch( errors => {
                    console.log(errors.response);
                    this.recordError(errors.response.data);
                  });
                console.log('iguales: ' + this.pass.password + " : " + this.pass.password_confirmation)
                console.log(this.vroute);
                this.passwordMismatch = false;
                setTimeout(function () {
                      window.location.replace( window.location.href );
                  }, 500);
            }else{
                console.log('mal: ' + this.pass.password + " : " + this.pass.password_confirmation)
                this.passwordMismatch = true;
            }

          }
        }
    }
</script>
