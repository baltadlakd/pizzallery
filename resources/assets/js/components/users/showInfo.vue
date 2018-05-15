<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <!--Generar contraseña-->
        <div class="card card-default">
          <div class="card-header">Información de usuario</div>

          <div class="card-body">
            <div class="container">
              <div class="form">
                <!--<form @keydown="clearError($event.target.name)">-->
                <img @error="item.user.avatar = imageLoadError()" class="mr-3 rounded border border-dark img-fluid" style="max-width: 50%;" v-bind:src="img(user.avatar)">
                <form @keydown="clearError($event.target.name)">

                  <fieldset class="form-group">
                    <label for="name">Nombre</label>
                    <input name="name" v-model="user.name" type="text" class="form-control" id="name" placeholder="Nombre" disabled>

                  </fieldset>
                  <fieldset class="form-group">
                    <label for="email">Correo electronico</label>
                    <input name="email" v-model="user.email" type="text" class="form-control" id="email" placeholder="Correo" disabled>
                  </fieldset>
                  <fieldset class="form-group">
                    <label for="age">Edad</label>
                    <div class="row">
                      <div class="col">
                        <select v-model="user.age" class="form-control" :class=" hasErrors('age') ? 'is-invalid' : '' ">
                          <option v-for="index in ageSelect" v-bind:value="index" v-model="user.age">
                            {{ index }}
                          </option>
                        </select>
                      </div>
                      <!--<div class="col">
                      <input name="age"
                      v-model.number="user.age" type="text" class="form-control"  id="age" placeholder="Edad"
                      :class=" hasErrors('age') ? 'is-invalid' : '' ">
                    </div>-->
                  </div>
                  <br>
                  <div class="container" v-for="error in getErrors('age')" >
                    <ul class="list-group">
                      <li class="list-group-item list-group-item-danger">{{error}}</li>
                    </ul>
                  </div>
                </fieldset>
                <fieldset class="form-group">
                  <label for="phone">Telefono</label>
                  <input name="phone" v-model="user.phone" type="text"
                  class="form-control" id="phone" placeholder="Telefono"
                  :class=" hasErrors('phone') ? 'is-invalid' : '' ">
                  <br>
                  <div class="container" v-for="error in getErrors('phone')" >
                    <ul class="list-group">
                      <li class="list-group-item list-group-item-danger">{{error}}</li>
                    </ul>
                  </div>
                </fieldset>
                <!--<small class="text text-danger" v-if="isAnyError()" > {{ errors.errors.password[0] }}</small>-->
                <br>
                <div class="dropdown-divider"> </div>
                <br>
                <button type="submit" class="btn btn-primary" v-on:click.prevent="updateUSer()">Aceptar</button>
              </form>
              <br>
              <!--<div v-if="passwordMismatch" class="alert alert-danger" role="alert">
              <strong>Advertencia! </strong> Las contraseñas no coinciden <a href="#" class="alert-link">, intenta de nuevo</a>.
            </div>-->
            <div class="alert alert-dismissible fade show" role="alert"
            v-if="notify.status" :class="[notify.status ? 'alert alert-success' : 'alert alert-danger']">
            <strong>{{notify.start}} </strong> {{notify.message}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>

      </div>
      <br>
      <div class="dropdown-divider"></div>
      <p>Redes sociales</p>
      <div class="container">
        <div class="row">
          <div class="col">
            <a class="btn btn-primary text-white" v-on:click.prevent="connectSocial(facebook,0)" >
              <i class="fab fa-facebook-square"></i>
              Facebook
              <i style="font-size:1em;" :class="[hasSocial('facebook') ? 'far fa-check-circle':'far fa-circle']"></i>
            </a>
          </div>
          <div class="col">
            <a class="btn btn-dark text-white" v-on:click.prevent="connectSocial(github,1)">
              <i class="fab fa-github-alt"></i>
              Github
              <i style="font-size:1em;" :class="[hasSocial('github') ? 'far fa-check-circle':'far fa-circle']"></i>
            </a>
          </div>
          <div class="col">
            <a class="btn btn-danger text-white" v-on:click.prevent="connectSocial(google,2)" >
              <i class="fab fa-google-plus-g"></i>
              Google+
              <i style="font-size:1em;" :class="[hasSocial('google') ? 'far fa-check-circle':'far fa-circle']"></i>
            </a>
          </div>

        </div>
      </div>
      <br>
      <div class="dropdown-divider"></div>
      <div class="container-fluid">
        <button type="button" class="btn btn-primary btn-lg btn-block" v-on:click.prevent="deleteUser()">Eliminar mi cuenta</button>
      </div>
    </div>
  </div>

  <br>

  <!--
  <form class="form" method="post" @keydown="clearError($event.target.name)">
  <div class="input-group mb-3">
  <input
  type="text" class="form-control" placeholder="Nuevo nombre"
  v-model="req.name" name="name">
  <div class="input-group-append">
  <button
  class="btn btn-outline-secondary" type="sumbit"
  v-on:click.prevent="editName()">actualizar</button>
</div>
</div>
</form>
<small class="text text-danger" v-if="isAnyError()" > {{ errors.errors.name[0] }}</small>


<div class="alert alert-dismissible fade show" role="alert"
v-if="notify.status" :class="[notify.status ? 'alert alert-success' : 'alert alert-danger']">
<strong>{{notify.start}} </strong> {{notify.message}}.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>-->

</div>

</div>

</div>
</template>

<script>
export default {
  mounted(){
    console.log("VUE_showInfo", this.uind);
  },
  created(){
    this.getUser();
  },
  data(){
    return{
      notify:{},
      errors:{},
      user:{},
      eliminar:false,
    }
  },
  computed:{
    ageSelect: function(){
      var ages = [];
      for( var i = 17;i<99;i++){
        ages.push(i)
      }
      return ages;
    },
  },
  props:[
    'uind',
    'upd',
    'facebook',
    'github',
    'google',
    'path',
  ],
  methods:{
    imageLoadError () {
      return null;
    },
    img(image){
      var path = '';
      if(image){
        path = window.location.origin + this.path+"storage/" + image;
      }else{
        path = window.location.origin + this.path+"imgs/avatar-1.png";
      }
      return path;
    },
    deleteUser(){
      swal({
        title: 'Estas seguro de eliminar tu usuario?',
        text: "Ya me enfade de andar en esto todo el finde semana!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminala',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: false
      }).then((result) => {
        if (result.value) {
          var url = window.location.origin + this.path + "usuario/" + this.user.id;
          axios.delete(url)
            .then(response=>{
              swal('Deleted!',"Tu cuenta ha sido eliminada :C",'success');
              setTimeout(function () {
                    window.location.replace( window.location.href );
                }, 1000);
            })
            .catch(errors=>{
              console.log(errors);
              swal('Ups!','Algo sucedió, reportalo con el administrador.','error');
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
          swal('Cancelado','No eliminaste tu cuenta :)','error');
        }
      })
    },
    connectSocial(social,opcion){
      switch(opcion){
        case 0:{
          if(this.hasSocial('facebook')){
            if(!this.user.hasPw){
              console.log("No tiene contraseña");
              swal("Crea una contraseña primero!");
            }
            else{
              var url = window.location.origin + this.path + "social/"+ this.getProvider('facebook');
              console.log(url);
              axios.delete(url)
              .then(response =>{
                this.getUser();
                this.notify = response.data;
              })
              .catch(errors =>{
                console.log(errors);
              })
            }
          }else{
            setTimeout(function () {
              window.location.replace(social);
            }, 300);
          }
          break;
        }
        case 1:{
          if(this.hasSocial('github')){
            if(!this.user.hasPw){
              console.log("No tiene contraseña");
              swal("Crea una contraseña primero!");
            }
            else{
              var url = window.location.origin + this.path + "social/"+ this.getProvider('github');
              console.log(url);
              axios.delete(url)
              .then(response =>{
                this.getUser();
                this.notify = response.data;
              })
              .catch(errors =>{
                console.log(errors);
              })
            }
          }else{
            setTimeout(function () {
              window.location.replace(social);
            }, 300);
          }
          break;
        }
        case 2:{
          if(this.hasSocial('google')){
            if(!this.user.hasPw){
              console.log("No tiene contraseña");
              swal("Crea una contraseña primero!");
            }
            else{
              var url = window.location.origin + this.path + "social/"+ this.getProvider('google');
              console.log(url);
              axios.delete(url)
              .then(response =>{
                this.getUser();
                this.notify = response.data;
              })
              .catch(errors =>{
                console.log(errors);
              })
            }
          }else{
            setTimeout(function () {
              window.location.replace(social);
            }, 300);
          }
          break;
        }

      }
    },
    getProvider(social){
      var id = 0;
      if(typeof this.user.social_provider !== 'undefined'){
        this.user.social_provider.forEach(function func(item){
          if(item.provider == social){
            id = item.id;
          }
          return false;
        })
      }
      return id;
    },
    hasSocial(social){
      var r = false;
      if(typeof this.user.social_provider !== 'undefined'){
        this.user.social_provider.forEach(function func(item){
          if(item.provider == social){
            r = true;
          }
          return false;
        })
      }
      return r;
    },
    clearError(error){
      if(this.hasErrors(error)){
        delete this.errors[error];
      }
    },
    getErrors(name){
      var errors = []
      if(this.hasErrors(name)){
        this.errors[name].forEach(function prueba(item){
          errors.push(item)
        });

      }
      return errors;
    },
    hasErrors(name){
      if(this.errors[name])
      {
        return true;
      }
      return false;
    },
    updateUSer(){
      axios.patch(this.upd,this.user)
      .then( response =>{
        console.log(response.data)
        this.errors = {};
        this.notify = response.data;
        this.user = this.notify.user;
        delete this.notify.user;
      })
      .catch( errors =>{
        console.log(errors.response.data);
        this.errors = errors.response.data.errors;
        this.notify = {};
      })
    },
    getUser(){
      axios.get(this.uind)
      .then( response =>{
        this.user = response.data;
      })
      .catch( errors => {
        console.log(errors);
      })
    },
  }
}
</script>

/*
id,nombre, correo, edad, telefono
*/
