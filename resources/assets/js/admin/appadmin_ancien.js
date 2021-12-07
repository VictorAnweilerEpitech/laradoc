const FormAddCategorie = {
  template: `
  <div class="bg-light border rounded p-4 mt-3">
    <div>
      <label class="form-label">Nom de la catégorie</label>
      <ul class="ml-0 pl-0 text-danger" v-if="errors.name">
        <template v-for="error in errors.name">
          <li><small>{{error}}</small></li>
        </template>
      </ul>
      <input class="form-control" :class="errors.name ? 'is-invalid' : ''" placeholder="Nom de la catégorie" v-model="name" />
    </div>
    <div class="mt-2">
      <button class="btn btn-primary" @click="sendForm" v-if="!loading">
          <i class="fas fa-plus" style="margin-right: 8px;"></i>Ajouter
      </button>
      <div class="spinner-border" role="status" v-if="loading">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  `,
  props: {
    url: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      name: "",
      loading: false,
      errors: []
    }
  },
  methods: {
    sendForm: async function() {
      this.loading = true
      await axios.post(this.url, {
        name: this.name
      })
      .then((response) => {
        this.errors = []
      })
      .catch((error) => {
        if (error.response) {
            this.errors = error.response.data.errors
        }
      })
      this.name = ""
      this.loading = false
    }
  }
}

var app = new Vue({
    el: '#app',
    components: {
      FormAddCategorie,
    },
    data: {
      message: 'Hello Vue!',
    }
})