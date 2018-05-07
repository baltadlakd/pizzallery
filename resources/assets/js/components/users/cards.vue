<template>
  <div id="upc">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">

          <!--Generar contraseña-->
          <div class="card card-default">
            <div class="card-header">Tarjetas del usuario</div>

            <div class="card-body">
              <div class="container" v-if="nueva == true || edit == true">
                <div class="form">
                  <form action="#" class="credit-card-div form">
                    <div class="panel panel-default" >
                      <div class="panel-heading">

                        <div class="row ">
                          <div class="col-md-12">
                            <input v-model.trim="newcard.number" type="text" class="form-control" placeholder="Numero de tarjeta" />
                          </div>
                        </div>
                        <div class="row ">
                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <span class="help-block text-muted small-font" > Expiry Month</span>
                                <select v-model="newcard.month" class="span3 form-control" name="expiry_month" id="expiry_month">
                                  <option></option>
                                  <option value="1">Jan (01)</option>
                                  <option value="2">Feb (02)</option>
                                  <option value="3">Mar (03)</option>
                                  <option value="4">Apr (04)</option>
                                  <option value="5">May (05)</option>
                                  <option value="6">June (06)</option>
                                  <option value="7">July (07)</option>
                                  <option value="8">Aug (08)</option>
                                  <option value="9">Sep (09)</option>
                                  <option value="10">Oct (10)</option>1
                                  <option value="11">Nov (11)</option>
                                  <option value="12">Dec (12)</option>
                                </select>
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                            <span class="help-block text-muted small-font" >  Expiry Year</span>
                            <select v-model="newcard.year" class="span2 form-control" name="expiry_year">
                              <option value="13">2013</option>
                              <option value="14">2014</option>
                              <option value="15">2015</option>
                              <option value="16">2016</option>
                              <option value="17">2017</option>
                              <option value="18">2018</option>
                              <option value="19">2019</option>
                              <option value="20">2020</option>
                              <option value="21">2021</option>
                              <option value="22">2022</option>
                              <option value="23">2023</option>
                            </select>
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                            <span class="help-block text-muted small-font" >  CCV</span>
                            <input v-model.number="newcard.ccv" type="number" min="100" max="9999" class="form-control" placeholder="CCV" />
                          </div>


                        </div>
                        <div class="row ">
                          <div class="col-md-12 pad-adjust">

                            <input v-model="newcard.name" type="text" class="form-control" placeholder="Nombre en la tarjeta" />
                          </div>
                        </div>
                        <div class="row ">
                          <div class="col-md-12 pad-adjust">

                            <input v-model="newcard.address" type="text" class="form-control" placeholder="Dirección" />
                          </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="row ">
                          <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                            <input type="submit"  class="btn btn-danger" value="Cancelar" v-on:click.prevent="editar(false),add(false)"/>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                            <input type="submit"  class="btn btn-warning btn-block" value="Agregar"
                              v-if="nueva == true && edit == false"
                              v-on:click.prevent="addCard()"/>
                            <input type="submit"  class="btn btn-warning btn-block" value="Editar"
                              v-if="nueva == false && edit == true"
                              v-on:click.prevent="updateCard()"/>
                          </div>
                        </div>

                      </div>
                    </div>
                  </form>

              </div>

            </div>
            <div class="row" v-else>
              <button type="button" class="btn btn-primary btn-lg btn-block" v-on:click="add(true)">
                <i class="fas fa-credit-card"></i>
                Añadir tarjeta
              </button>
            </div>
            <br>
            <br>
            <div class="alert alert-dismissible fade show" role="alert"
            v-if="notify.status" :class="[notify.status ? 'alert alert-success' : 'alert alert-danger']">
            <strong>{{notify.start}} </strong> {{notify.message}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <br>
            <!-- listado de tarjetas -->
            <div class="container" v-if="laravelData.length">
            <table class="table table-hover table-striped">
          			<thead>
          				<tr>
                    <th>Número</th>
          					<th>Tarjeta nombre</th>
                    <th>Fecha</th>
          					<th colspan="2">
          						&nbsp;
          					</th>
          				</tr>
          			</thead>
          			<tbody>
          				<tr v-for="cc in laravelData">
          					<td>{{ cc.number }}</td>
          					<td>{{ cc.name }}</td>
                    <td>{{ cc.fecha }}</td>
          					<td width="3px">
                      <button type="button" class="btn btn-warning btn-sm " v-on:click.prevent="editCard(cc.id)">
                        <i class="fas fa-edit"></i>
                      </button>
          					</td>
          					<td width="3px">
                      <button type="button" class="btn btn-danger btn-sm" v-on:click.prevent="deleteCard(cc.id)">
                        <i class="fas fa-trash-alt"></i>
                      </button>
          					</td>
          				</tr>
          			</tbody>
          		</table>



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
  mounted(){
    console.log("VUE_cards");
  },
  created(){
    this.getCards();
  },
  data(){
    return{
      nueva: false,
      edit:false,
      notify:{},
      newcard:{
        number:'',
        month:'',
        year:'',
        ccv:'',
        name:'',
        address:'',
      },
      laravelData:{},
    }
  },
  props:[
    'path',
    'user',
  ],
  methods:{
    add(value){
      this.nueva = value;
    },
    editar(value){
      this.edit=value;
      if(!this.edit){
        this.newcard = {};
      }
    },
    getCards(page){
        if(typeof page === 'undefined'){
          page = 1;
        }
        var url = window.location.origin + this.path + "tarjetas" + "?page=" + page;
        console.log(url);
        axios.get(url)
          .then( response =>{
            this.laravelData = response.data;
          })
          .catch( errors => {
            this.errors = errors.data;
          })
    },
    addCard(){
      var url = window.location.origin + this.path + "tarjetas";
      this.newcard.user = this.user;
      axios.post(url,this.newcard)
        .then(response =>{
          console.log(response);
          this.newcard = {};
          this.add(false);
          this.getCards();
        })
        .catch(errors=>{
          console.log(errors);
        });
    },
    deleteCard(cardid){
      var url = window.location.origin + this.path + "tarjetas/" + cardid;
      console.log(url);
      axios.delete(url)
        .then(response =>{
          console.log(response);
          this.notify = response.data;
          this.getCards();
        })
        .catch(errors=>{
          console.log(errors);
        });
    },
    editCard(cardid){
      if(this.nueva){
        this.add(false);
      }
      var url = window.location.origin + this.path + "tarjetas/" + cardid + "/edit";
      axios.get(url)
        .then(response=>{
          this.newcard = response.data;
          this.editar(true);
          this.newcard.number = this.newcard.number.replace(/\s*/g, "");
        })
        .catch(errors=>{
          consosle.log(errors);
        });
    },
    updateCard(){
      var url = window.location.origin + this.path + "tarjetas/" + this.newcard.id ;
      axios.patch(url,this.newcard)
        .then(response=>{
            console.log(response.data);
            this.notify = response.data;
            this.newcard = {};
            this.editar(false);
            this.getCards();
        })
        .catch(errors=>{
          console.log(errors);
        });
    },
  }
}
</script>

<style>
.credit-card-div  span { padding-top:10px; }
.credit-card-div img { padding-top:30px; }
.credit-card-div .small-font { font-size:9px; }
.credit-card-div .pad-adjust { padding-top:10px; }
</style>
