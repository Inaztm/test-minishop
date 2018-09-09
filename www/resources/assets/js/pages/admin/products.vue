<template>
  <card :title="$t('your_info')">
    <nav slot="header_action">
      <button-modal
        title="Create product"
        id-modal="create_product"
        :small="true">
        <form @submit.prevent="create" @keydown="form.onKeydown($event)">
          <alert-success :form="form" message="created"/>

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" type="text" name="name" class="form-control"
                :class="{ 'is-invalid': form.errors.has('name') }">
              <has-error :form="form" field="name"/>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.price" type="text" name="price" class="form-control"
                :class="{ 'is-invalid': form.errors.has('price') }">
              <has-error :form="form" field="price" />
            </div>
          </div>

          <div class="form-group text-md-right">
            <v-button type="success" :loading="form.busy">Create</v-button>
          </div>
        </form>
      </button-modal>
    </nav>

    <ul class="list-group list-group-flush">
      <li
        class="list-group-item"
        v-for="product in products"
        :key="product.id">
        <section class="d-flex align-items-center justify-content-between">
          <span>{{ product.name }} - {{ product.price }}</span>
        </section>
      </li>
    </ul>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      price: ''
    })
  }),

  computed: mapGetters({
    products: 'products/products'
  }),

  created () {
    this.$store.dispatch('products/fetchProducts')

    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async create () {
      const { data } = await this.form.post('/api/products/create')

      this.products.push(data)
    }
  }
}
</script>