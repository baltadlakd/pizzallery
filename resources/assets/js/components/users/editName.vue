<template>
  <div id="editname">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">

          <br>
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
          </div>

        </div>

      </div>
      <br><br>

    </div>

  </div>

</template>

<script>
export default {
  mounted(){
    console.log('VUE_editName');
  },
  data(){
    return{
      req:{
        name:''
      },
      notify:{
        start:'',
        message:'',
        status:false,
        show:false,
      },
      errors:{},
    }
  },
  props:[
    'vuser',
    'vroute',
  ],
  methods:{
    isAnyError(){
      if(this.errors.errors){
        return true;
      }
    },
    editName(){
      axios.post(this.vroute,this.req)
        .then(response =>{
          this.notify = response.data;
          if(this.notify.status){
            this.req = {};
            this.errros = {};
          }
        })
        .catch(errors => {
          this.errors = errors.response.data;
        });
    },
    clearError(error){
      if(this.isAnyError()){
        console.log("clear" + error);
        delete this.errors.errors[error][0];
      }
    },
  }
}
</script>
