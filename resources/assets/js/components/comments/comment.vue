<template>
  <div class="container-fluid">
    <div class="card" >
      <div class="card-header">
        Comentarios
      </div>


      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <form class="form-group" @keydown="clearError($event.target.name)">
            <div class="input-group mb-3">
              <textarea :class=" hasErrors('comment') ? 'is-invalid' : '' " v-model="box" id="comment" name="comment" class="form-control" aria-label="With textarea"></textarea>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" v-on:click.prevent="sumbitPost()">Comentar</button>
              </div>
            </div>
            <div class="container" v-for="error in getErrors('comment')" >
              <ul class="list-group">
                <li class="list-group-item list-group-item-danger">{{error}}</li>
              </ul>
            </div>
          </form>
        </li>
        <li v-for="item in comments" class="list-group-item">
          <!--Comment start-->
          <div class="media">
            <img @error="item.user.avatar = imageLoadError()" class="mr-3 rounded border border-dark img-fluid" style="max-width: 7%;" v-bind:src="img(item.user.avatar)">
            <div class="media-body">
              <p class="font-weight-bold text-left" style="margin-bottom:0;">{{item.user.name}}</p>
              <span class="help-block text-muted small-font" >{{ getHumanDate(item.updated_at) }}</span>
              <div class="dropdown-divider"></div>
              <p>{{item.message}}</p>
            </div>
          </div>
          <!--Comment end-->
        </li>

      </ul>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
export default {
  mounted(){
    console.log("VUE_comments");
  },
  created(){
    this.path = process.env.MIX_PATH;
    this.getComments();
  },
  props:[
    'id',
    'type',
  ],
  data(){
    return{
      path:'',
      comments:{},
      errors:{},
      box:'',
    }
  },
  methods:{
    imageLoadError () {
      return null;
    },
    img(image){
      var path = '';
      if(image){
        path = window.location.origin + this.path+"storage/" + image;
        console.log("imagen->",path);
      }else{
        path = window.location.origin + this.path+"imgs/avatar-1.png";
      }
      return path;
    },
    getHumanDate : function (date) {

      return moment.utc(date).local().format('MM/DD/YYYY, h:mm a');
    },
    getComments(){
      if(this.type == "pizza"){
        var url = window.location.origin + this.path + "comentarios/pizza/" + this.id;
      }else if(this.type == "hamburger"){
        var url = window.location.origin + this.path + "comentarios/hamburguesa/" + this.id;
      }else{
        return console.log("Type Error");
      }
      axios.get(url)
      .then(response=>{
        this.comments = response.data;
      })
      .catch(response=>{
        console.log(response);
      });
    },
    sumbitPost(){
      if(this.type == "pizza"){
        var url = window.location.origin + this.path + "comentarios/pizza/" + this.id;
      }else if(this.type == "hamburger"){
        var url = window.location.origin + this.path + "comentarios/hamburguesa/" + this.id;
      }
      console.log(url);
      axios.post(url,{
        comment:this.box
      })
      .then(response=>{
        console.log(response);
        this.getComments();
        this.box = '';
        swal('Nuevo comentario!');
      })
      .catch(errors=>{
        this.errors = errors.response.data.errors;
      });
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
  }
}
</script>

<style>
.small-font { font-size:9px; }

</style>
