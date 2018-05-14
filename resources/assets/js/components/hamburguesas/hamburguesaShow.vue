<template>
  <div class="container-fluid" v-if="hamburger.id > 0">
    <div class="card text-center">
      <div class="card-body">
        <div class="row">
          <div class="col-sm">
            <div class="container">
              <img src="http://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2016/06/hamburguesa.jpg" alt="..." class="img-thumbnail">

            </div>
          </div>
          <div class="col-sm">
            <div class="card text-center">
              <div class="card-header">
                {{hamburger.title}}
              </div>
              <div class="card-body">
                <h5 class="card-title font-weight-bold">
                  <i class="fas fa-dollar-sign"></i> {{hamburger.price}}
                </h5>
                <p class="card-text">{{hamburger.description}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-muted">
        <small> actualizado {{ getHumanDate(hamburger.updated_at) }}</small>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
export default {
  mounted(){
    console.log("Vue_Showhamburger");
  },
  created(){
    this.path = process.env.MIX_PATH;
    this.getHamburger(this.idHamburger);
  },
  props:[
    'idHamburger',
    'owner',
  ],
  data(){
    return{
      hamburger:{},
      errors:{},
      path:'',
    }
  },
  methods:{
    getHamburger(id){
      var url = window.location.origin + this.path+"hamburguesa/"+id;
      console.log(url);
      axios.get(url)
      .then(response=>{
        console.log(response);
        this.hamburger = response.data;
      })
      .catch(errors=>{
        this.errors = errors.data;
      })
    },
    getHumanDate : function (date) {

      return moment.utc(date).local().format('MM/DD/YYYY, h:mm a');
    }
  }
}
</script>

<style lang="css">
</style>
