<template>
  <div class="container">
    <div class="row justify-content-center">
      <!-- paginación -->
      <nav aria-label="Page">
        <ul class="pagination justify-content-center">
          <li v-if="laravelData.current_page > 1" class="page-item">
            <a class="page-link" href="#" aria-label="Previous"
            v-on:click.prevent="changePage(laravelData.current_page - 1)">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>

        <li v-for="page in pagesNumber" class="page-item" v-bind:class="[ page == isActived ? 'active' : '']">
          <a href="#" class="page-link"
          v-on:click.prevent="changePage(page)">
          {{ page }}
        </a>
      </li>

      <li class="page-item" v-if="laravelData.current_page < laravelData.last_page" >
        <a class="page-link" href="#" aria-label="Next"
        v-on:click.prevent="changePage(laravelData.current_page + 1)">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
<!-- paginación -->
</div>
<div class="row">
  <!-- Card pizza -->
  <div v-for="item in laravelData.data" class="col-sm-6 col-md-4 col-lg-3 mt-4">
    <div class="card card-inverse card-info">
      <img class="card-img-top" src="imgs/pizza.jpg">
      <div class="card-block">
        <figure class="profile">
          <img src="imgs/avatar-1.png" class="profile-avatar" alt="">
        </figure>
        <div class="meta card-text text-info">
          <span class="badge badge-pill badge-info">{{ item.user.name }}</span>
        </div>
        <h3 class="card-title mt-3">
          {{ item.title }}
          <span alt="Pedidos " v-if="item.bought > 1" class="badge badge-dark">
             {{item.bought}}
           </span>
           <span alt="Pedidos " v-else class="badge badge-dark">
              new
            </span>
        </h3>
        <div class="meta card-text">
          <a>${{ item.price }}</a>
        </div>
        <div class="card-text">
          {{ item.description }}
        </div>
      </div>
      <div class="card-footer">
        <small>{{ getHumanDate(item.updated_at) }}</small>
        <button v-on:click="show(item.id)"  class="btn btn-info float-right btn-sm">Ver más</button>
      </div>
    </div>
  </div>
  <!---->
</div>
</div>
</template>

<script>
import moment from 'moment';
export default {
  mounted(){
    console.log("VUE_pizzaIndex");
  },
  created(){
    this.path = process.env.MIX_PATH;
    this.getPizzas();
  },
  data(){
    return{
      laravelData:{},
      offset:5,
      errors:{},
      path:'',
    }
  },
  methods:{
    show(id){
      window.location.replace(this.path + "pizza/" + id);
    },
    getPizzas(page){
      if(typeof page === 'undefined'){
        page = 1;
      }
      var url = window.location.origin + this.path+"pizza" + "?page=" + page;
      console.log("Consulta : ",url);
      axios.get(url)
      .then( response => {
        this.laravelData = response.data ;
      })
      .catch( errors=>{
        this.errors = errors.data;
      })
    },
    changePage(page){
      this.getPizzas(page);
    },
    getHumanDate : function (date) {

      return moment.utc(date).local().format('MM/DD/YYYY, h:mm a');
    }
  },
  computed:{
    isActived: function() {
      return this.laravelData.current_page;
    },
    pagesNumber: function() {
      if(!this.laravelData.to){
        return [];
      }
      var pagesArray = [];
      var from = this.laravelData.current_page - this.offset;
      if(from < 1){
        from = 1;
      }else{
        pagesArray.push(1);
      }
      var f = false;
      var to = from + (this.offset * 2);
      if(to >= this.laravelData.last_page){
        to = this.laravelData.last_page;
      }else{
        f = true
      }

      while(from <= to){
        if(! pagesArray.includes(from) ){
          pagesArray.push(from);
        }
        from++;
      }
      if(f){
        pagesArray.push(this.laravelData.last_page);
      }
      return pagesArray;
    }
  }
}
</script>




<style lang="css">
html {
  font-family: Lato, 'Helvetica Neue', Arial, Helvetica, sans-serif;
  font-size: 14px;
}

h5 {
  font-size: 1.28571429em;
  font-weight: 700;
  line-height: 1.2857em;
  margin: 0;
}

.card {
  font-size: 1em;
  overflow: hidden;
  padding: 0;
  border: none;
  border-radius: .28571429rem;
  box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
}

.card-block {
  font-size: 1em;
  position: relative;
  margin: 0;
  padding: 1em;
  border: none;
  border-top: 1px solid rgba(34, 36, 38, .1);
  box-shadow: none;
}

.card-img-top {
  display: block;
  width: 100%;
  height: auto;
}

.card-title {
  font-size: 1.28571429em;
  font-weight: 700;
  line-height: 1.2857em;
}

.card-text {
  clear: both;
  margin-top: .5em;
  color: rgba(0, 0, 0, .68);
}

.card-footer {
  font-size: 1em;
  position: static;
  top: 0;
  left: 0;
  max-width: 100%;
  padding: .75em 1em;
  color: rgba(0, 0, 0, .4);
  border-top: 1px solid rgba(0, 0, 0, .05) !important;
  background: #fff;
}

.card-inverse .btn {
  border: 1px solid rgba(0, 0, 0, .05);
}

.profile {
  position: absolute;
  top: -12px;
  display: inline-block;
  overflow: hidden;
  box-sizing: border-box;
  width: 25px;
  height: 25px;
  margin: 0;
  border: 1px solid #fff;
  border-radius: 50%;
}

.profile-avatar {
  display: block;
  width: 100%;
  height: auto;
  border-radius: 50%;
}

.profile-inline {
  position: relative;
  top: 0;
  display: inline-block;
}

.profile-inline ~ .card-title {
  display: inline-block;
  margin-left: 4px;
  vertical-align: top;
}

.text-bold {
  font-weight: 700;
}

.meta {
  font-size: 1em;
  color: rgba(0, 0, 0, .4);
}

.meta a {
  text-decoration: none;
  color: rgba(0, 0, 0, .4);
}

.meta a:hover {
  color: rgba(0, 0, 0, .87);
}
</style>
