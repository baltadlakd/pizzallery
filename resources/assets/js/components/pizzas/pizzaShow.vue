<template>
  <div class="container-fluid" v-if="pizza.id > 0">
    <div class="card text-center">
      <div class="card-header">
        Pizza de {{pizza.user.name}}
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm">
            <div class="container">
              <img src="http://i.ngenespanol.com/dam/tbg/traveler/agenda/18/02/15/pizza-desayuno-2.png.imgw.1280.1280.png" alt="..." class="img-thumbnail">

            </div>
          </div>
          <div class="col-sm">
            <div class="card text-center">
              <div class="card-header">
                {{pizza.title}}
              </div>
              <div class="card-body">
                <h5 class="card-title font-weight-bold">
                  <i class="fas fa-dollar-sign"></i> {{pizza.price}}
                </h5>
                <p v-if="pizza.bought > 1"> Comprada {{pizza.bought}} veces</p>
                <p v-else-if="pizza.bought == 0"> Se el primero en ordenarla!</p>
                <p v-else> Comprada {{pizza.bought}} vez</p>
                <p class="card-text">{{pizza.description}}</p>

                <!---->
                <div v-if=" owner == pizza.user_id && edit == true">
                  <input-tag
                    v-bind:limit='limit'
                    v-bind:tags.sync='tags'
                    v-bind:placeholder='placeholder'
                    v-bind:read-only='readOnly'
                    v-bind:validate='validate'
                    v-bind:add-tag-on-blur='addTagOnBlur'
                  ></input-tag>
                  <button v-on:click.prevent="saveTags()" type="button" class="btn btn-primary">Guardar ingredientes</button>
                </div>
                <div v-else-if="edit == false">
                  <span v-for="ingrediente in tags" class="badge badge-pill badge-warning">
                     {{ingrediente}}
                  </span>
                  <button v-on:click.prevent="setEdit(true)" type="button" class="btn btn-primary">Editar</button>
                </div>
                <br>
                <!---->

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-muted">
        <small> actualizado {{ getHumanDate(pizza.updated_at) }}</small>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import InputTag from 'vue-input-tag'
export default {
  mounted(){
    console.log("Vue_ShowPizza");
    this.path = process.env.MIX_PATH;
    this.getPizza(this.idPizza);
    this.getTags();
  },
  props:[
    'idPizza',
    'owner'
  ],
  data(){
    return{
      pizza:{},
      errors:{},
      path:'',
      limit: 10,
      tags:['pimiento','salsa'],
      placeholder: 'Añadir ingrediente',
      readOnly: false,
      addTagOnBlur: false,
      htmlCode: '',
      validate: '',
      edit:false,
    }
  },
  components: {
    InputTag,
  },
  methods:{
    setEdit(value){
      this.edit = value;
    },
    getTags(){
      var url = window.location.origin + this.path+"ingredientes/pizza/"+this.idPizza;
      var tags=[];
      axios.get(url)
        .then(response=>{
          response.data.forEach(function func(item){
            tags.push(item.ingrediente);
          });
          this.tags = tags;
        })
        .catch(errors=>{
          console.log(errors);
        })
    },
    getPizza(id){
      var url = window.location.origin + this.path+"pizza/"+id;
      console.log(url);
      axios.get(url)
      .then(response=>{
        console.log(response);
        this.pizza = response.data;
      })
      .catch(errors=>{
        console.log("error",errors);
      })
    },
    getHumanDate : function (date) {
      return moment.utc(date).local().format('MM/DD/YYYY, h:mm a');
    },
    saveTags(){
      var url = window.location.origin + this.path+"ingredientes/pizza/"+this.idPizza;
      axios.post(url,this.tags)
        .then(response=>{
          console.log(response);
          swal("Se actualizó");
          this.setEdit(false);
        })
        .catch(errors=>{
          console.log("error",errors);
        })
    }
  }
}
</script>
