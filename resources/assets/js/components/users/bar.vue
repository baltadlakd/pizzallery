<template>
  <div class="container-fluid mh-100">
    <div class="row mh-100">
        <aside class="col-12 col-md-2 p-0 bg-dark">
            <nav class="navbar navbar-expand navbar-dark bg-dark flex-md-column flex-row align-items-start">
                <div class="collapse navbar-collapse">
                    <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between">
                      <li class="nav-item">
                          <a class="nav-link pl-0" href="#" v-on:click.prevent="option(0)">Información</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link pl-0" href="#" v-on:click.prevent="option(1)">Cambiar nombre</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link pl-0" href="#" v-on:click.prevent="option(2)" >Cambiar contraseña</a>
                      </li>
                      <!--<li class="nav-item">
                          <a class="nav-link pl-0" href="#" v-on:click.prevent="option(3)">Usuarios</a>
                      </li>-->
                      <li class="nav-item">
                          <a class="nav-link pl-0" href="#" v-on:click.prevent="option(4)">Formas de pago</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link pl-0" href="#" v-on:click.prevent="option(5)">Cambiar avatar</a>
                      </li>
                    </ul>
                </div>
            </nav>
        </aside>
        <main class="col">
          <br><br>

            <div class="container-fluid"
              v-if="menu == 0">
                <show-info
                  v-bind:uind='uind'
                  v-bind:upd='upd'
                  v-bind:facebook='fb'
                  v-bind:github='gh'
                  v-bind:google='gp'
                  v-bind:path='path'
                  ></show-info>


            </div>

            <edit-name
              v-if="menu == 1"
              v-bind:vroute='ren'
            >
            </edit-name>
            <create-password
              v-if="cou == 1 && menu == 2"
              v-bind:vroute="rcp"
              v-bind:vuser="uind"
            >
            </create-password>
            <update-password
              v-if="cou == 0 && menu == 2"
              v-bind:vroute="rup"
            >
          </update-password>
          <!--<div v-if="menu == 3" class="container-fluid">
            <user-table v-bind:ruta="all"> </user-table>

          </div>-->
          <div class="container-fluid"
            v-if="menu == 4">
              <cards
                v-bind:path='path'
                v-bind:user='ru' ></cards>
          </div>

        </main>
    </div>
</div>



</template>

<script>
export default {
  mounted(){
    console.log("VUE_bar");
    this.path = process.env.MIX_PATH;
  },
  created(){
  },
  data(){
    return{
      menu:0,
      path:'',
    }
  },
  props: [
    'ren',
    'ru',
    'rup',
    'rcp',
    'cou',
    'all',
    'uind',
    'upd',
    'fb',
    'gh',
    'gp',
  ],
  methods:{
    option(c){
      if(c == 5){
        var route = window.location.origin +this.path+"avatar";
        console.log(".",route);
        setTimeout(function () {
            console.log("-",route);
            window.location.replace( route );
          }, 500);
      }
      this.menu = c;
      console.log(c);
    },
  }
}
</script>
