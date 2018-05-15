<template>
  <div class="container-fluid">

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
      <img class="card-img-top" v-bind:src="imagen(item.hashed)">
      <div class="card-block">
        <h3 class="card-title mt-3">
          {{ item.original }}
        </h3>
      </div>
      <div class="card-footer">
        <button v-if="active != item.hashed" v-on:click.prevent="setProfile(item.id)" type="button" class="btn btn-primary">Elegir!</button>
        <p v-else> Avatar actual!</p>
        <button v-if="isAdmin == '1'" v-on:click.prevent="deleteImg(item.id)" type="button" class="btn btn-danger">Eliminar</button>
      </div>
    </div>
  </div>
  <!---->
</div>
</div>
</template>

<script>
export default {
  mounted(){
    console.log("VUE_avatars");
    this.path = process.env.MIX_PATH;
    this.getAvatars();
    this.getActive();
  },
  data(){
    return{
      laravelData:{},
      offset:4,
      errors:{},
      path:'',
      active:'',
    }
  },
  props:[
    'user',
    'isAdmin',
  ],
  methods:{
    getActive(){
      var url = window.location.origin + this.path+"usuario/avatar/"+this.user;
      axios.get(url)
      .then(response=>{
        this.active = response.data;
      })
      .catch(errors=>{
        this.errors=errors.response.data;
      });
    },
    deleteImg(item){
      swal({
        title: 'Estas seguro de eliminar esta imagen?',
        text: "La imagen se eliminará para todos!",
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
          var url = window.location.origin + this.path + "avatar/" + item;
          console.log("...",url);
          axios.delete(url)
            .then(response=>{
              swal('Deleted!',"Tu cuenta ha sido eliminada :C",'success');
              console.log(response);
            })
            .catch(errors=>{
              console.log(errors);
              swal('Ups!','Algo sucedió, reportalo con el administrador.','error');
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
          swal('Cancelado','No eliminaste la imagen :)','error');
        }
      })
    },
    setProfile(id){
      if(typeof this.user ==='undefined'){
        swal("Not an user!");
        return;
      }
      var url = window.location.origin + this.path+"avatar/set";
      axios.post(url,{
        userid:this.user,
        avatarid:id
      })
      .then(response=>{
        console.log(response);
        setTimeout(function () {
              window.location.replace( window.location.href );
          }, 500);
      })
      .catch(errors=>{
        console.log(errors);
      });
    },
    changePage(page){
      this.getAvatars(page);
    },
    imagen(image){
      var url = window.location.origin + this.path+"storage/"+image;
      return url;
    },
    getAvatars(page){
      if(typeof page === 'undefined'){
        page = 1;
      }
      var url = window.location.origin + this.path+"avatar/all" + "?page=" + page;
      axios.get(url)
      .then(response=>{
        this.laravelData = response.data;
      })
      .catch(errors=>{
        this.errors=errors.response.data;
      });
    },
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

<style>
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
