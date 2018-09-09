<template>
  <div>
    <div class="text-center">
      <div class="title mb-4">
        Checkout
      </div>
    </div>

    <form
      v-if="!order"
      @submit.prevent="checkout"
      @keydown="form.onKeydown($event)">
      <div class="form-group">
        <label for="exampleFormControlInput1">Name</label>
        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('name') }"
          v-model="form.name">
        <has-error :form="form" field="name"/>
      </div>

      <div class="form-group">
        <label>Email address</label>
        <input
          type="email"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('email') }"
          v-model="form.email">
        <has-error :form="form" field="email"/>
      </div>

      <div class="form-group">
        <label>Phone</label>
        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('phone') }"
          v-model="form.phone">
        <has-error :form="form" field="phone"/>
      </div>

      <div class="form-group">
        <label>Products</label>
        <select
          multiple
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('products') }"
          v-model="form.products">
          <option
            v-for="product in products"
            :key="product.id"
            :value="product.id">
            {{ product.name }} - ${{ product.price }}
          </option>
        </select>
        <has-error :form="form" field="products"/>
      </div>

      <div class="form-group">
        <label>Comment</label>
        <textarea
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('comment') }"
          rows="3"
          v-model="form.comment"></textarea>
        <has-error :form="form" field="comment"/>
      </div>

      <div class="form-group">
        <label>Total price</label>
        <b>${{ form.total_price }}</b>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary mb-2">Checkout</button>
      </div>
    </form>

    <ul v-if="order" class="list-group list-group-flush">
      <li class="list-group-item">Name - {{ order.name }}</li>
      <li class="list-group-item">Email - {{ order.email }}</li>
      <li class="list-group-item">Phone - {{ order.phone }}</li>
      <li v-if="order.comment" class="list-group-item">Comment - {{ order.comment }}</li>
      <li class="list-group-item">Total parice - {{ order.total_price }}</li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  computed: mapGetters({
    products: 'products/products'
  }),

  data: () => ({
    title: window.config.appName,
    form: new Form({
      name: '',
      email: '',
      phone: '',
      comment: '',
      products: [],
      total_price: 0
    }),
    order: null
  }),

  created () {
    this.$store.dispatch('products/fetchProducts')
  },

  methods: {
    async checkout () {
      const { data } = await this.form.post('/api/orders/create')

      this.order = data
    }
  },
  
  watch: {
    'form.products': function(newValue, oldValue) {
      this.form.total_price = 0

      newValue.map(id => {
        let product = this.products.filter(product => product.id == id)[0]

        this.form.total_price += parseFloat(product.price)
      })
    }
  }
}
</script>

<style scoped>

.title {
  font-size: 23px;
}
</style>