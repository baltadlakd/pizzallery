<template>
  <div class="container">
  <table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Usuario</th>
          <th>Correo</th>
					<th colspan="3">
						&nbsp;
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in laravelData.data">
					<td width="10px">{{ user.id }}</td>
					<td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td width="5px">
						<!-- Facebook -->
            <button type="button" class="btn btn-primary btn-sm text-white">
              <i class="fab fa-facebook-square"></i>
              <i style="font-size:1em;" :class="[hasSocial(user.social_provider,'facebook') ? 'far fa-check-circle':'far fa-circle']"></i>
            </button>
					</td>
          <td width="5px">
						<!-- Github -->
            <button type="button" class="btn btn-dark btn-sm text-white">
              <i class="fab fa-github-alt"></i>
              <i style="font-size:1em;" :class="[hasSocial(user.social_provider,'github') ? 'far fa-check-circle':'far fa-circle']"></i>
            </button>
					</td>
          <td width="5px">
						<!-- Google -->
            <button type="button" class="btn btn-danger btn-sm text-white">
              <i class="fab fa-google-plus-g"></i>
              <i style="font-size:1em;" :class="[hasSocial(user.social_provider,'google') ? 'far fa-check-circle':'far fa-circle']"></i>
            </button>
					</td>
				</tr>
			</tbody>
		</table>

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

  </div>
</template>

<script>
export default {
  mounter() {
    console.log("VUE_userTable");
  },
  created(){
    this.getUsers();
  },
  data(){
    return{
      laravelData: {},
      page:'',
      errors:{},
      offset:2,
    }
  },
  props:[
    'ruta',
  ],
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
  },
  methods:{
    hasSocial(user,social){
      var r = false;
      if(typeof user !== 'undefined'){
        user.forEach(function func(item){
          if(item.provider == social)
          r = true;
          return;
        })
      }
      return r;
    },
    changePage(page){
      this.getUsers(page);
    },
    getUsers(page){
      if(typeof page === 'undefined'){
        page = 1;
      }
      var url = this.ruta + "?page=" + page;
      console.log(url);
      axios.get(url)
        .then( response =>{
          this.laravelData = response.data;
        })
        .catch( errors => {
          this.errors = errors.data;
        })
    }
  }
}
</script>
